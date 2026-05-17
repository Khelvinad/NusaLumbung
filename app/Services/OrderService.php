<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\InvalidOrderStatusTransitionException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @param  list<array{product_id: int, quantity: int}>  $items
     * @return list<Order>
     */
    public function checkout(User $pembeli, array $items): array
    {
        return DB::transaction(function () use ($pembeli, $items) {
            $quantitiesByProduct = collect($items)
                ->groupBy('product_id')
                ->map(fn (Collection $lines) => (int) $lines->sum('quantity'));

            $products = Product::query()
                ->whereIn('id', $quantitiesByProduct->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $quantitiesByProduct->count()) {
                throw new InsufficientStockException('Produk tidak ditemukan');
            }

            $this->assertStockAvailable($products, $quantitiesByProduct);

            $orders = [];

            $groupedByPetani = $quantitiesByProduct->map(
                fn (int $quantity, int $productId) => [
                    'product' => $products[$productId],
                    'quantity' => $quantity,
                ],
            )->groupBy(fn (array $line) => $line['product']->user_id);

            foreach ($groupedByPetani as $petaniId => $lines) {
                $order = Order::create([
                    'pembeli_id' => $pembeli->id,
                    'petani_id' => $petaniId,
                    'status' => OrderStatus::Pending,
                    'total_amount' => 0,
                ]);

                $total = 0;

                foreach ($lines as $line) {
                    /** @var Product $product */
                    $product = $line['product'];
                    $quantity = $line['quantity'];
                    $lineTotal = $product->price * $quantity;
                    $total += $lineTotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price_snapshot' => $product->price,
                        'product_name_snapshot' => $product->name,
                    ]);
                }

                $order->update(['total_amount' => $total]);
                $orders[] = $order->load(['items.product', 'pembeli', 'petani']);
            }

            return $orders;
        });
    }

    public function confirm(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            $order = Order::query()->lockForUpdate()->findOrFail($order->id);

            $this->assertTransition($order->status, OrderStatus::Confirmed);

            foreach ($order->items as $item) {
                $product = Product::query()->lockForUpdate()->findOrFail($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw new InsufficientStockException($product->name);
                }

                $product->decrement('stock', $item->quantity);
            }

            $order->update(['status' => OrderStatus::Confirmed]);

            return $order->fresh(['items.product', 'pembeli', 'petani']);
        });
    }

    public function updateStatus(Order $order, OrderStatus $newStatus): Order
    {
        return DB::transaction(function () use ($order, $newStatus) {
            $order = Order::query()->lockForUpdate()->findOrFail($order->id);
            $currentStatus = $order->status;

            $this->assertTransition($currentStatus, $newStatus);

            if ($newStatus === OrderStatus::Cancelled && $currentStatus->hasReservedStock()) {
                $this->restoreStock($order);
            }

            $order->update(['status' => $newStatus]);

            return $order->fresh(['items.product', 'pembeli', 'petani']);
        });
    }

    /**
     * @param  Collection<int, Product>  $products
     * @param  Collection<int, int>  $quantitiesByProduct
     */
    protected function assertStockAvailable(Collection $products, Collection $quantitiesByProduct): void
    {
        foreach ($quantitiesByProduct as $productId => $quantity) {
            $product = $products[$productId];

            if ($product->stock < $quantity) {
                throw new InsufficientStockException($product->name);
            }
        }
    }

    protected function assertTransition(OrderStatus $from, OrderStatus $to): void
    {
        if (! $from->canTransitionTo($to)) {
            throw new InvalidOrderStatusTransitionException($from, $to);
        }
    }

    protected function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            Product::query()
                ->whereKey($item->product_id)
                ->increment('stock', $item->quantity);
        }
    }
}
