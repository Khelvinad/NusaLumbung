<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\CheckoutOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly OrderService $orderService) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        $user = $request->user();

        $orders = Order::query()
            ->with(['items.product', 'pembeli', 'petani', 'reviews'])
            ->when(
                $user->hasRole('pembeli'),
                fn ($query) => $query->where('pembeli_id', $user->id),
            )
            ->when(
                $user->hasRole('petani') && ! $user->hasRole('pembeli'),
                fn ($query) => $query->where('petani_id', $user->id),
            )
            ->latest()
            ->paginate(15);

        if ($request->expectsJson() || $request->is('api/*')) {
            return OrderResource::collection($orders);
        }

        return view('pembeli.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new OrderResource($order->load(['items.product', 'pembeli', 'petani']));
        }

        $order->load(['items.product', 'pembeli', 'petani']);
        return view('pembeli.orders.show', compact('order'));
    }

    public function checkout(CheckoutOrderRequest $request): JsonResponse
    {
        $this->authorize('create', Order::class);

        $orders = $this->orderService->checkout(
            $request->user(),
            $request->validated('items'),
        );

        return OrderResource::collection(collect($orders))
            ->response()
            ->setStatusCode(201);
    }

    public function confirm(Request $request, Order $order)
    {
        $this->authorize('confirm', $order);

        $order = $this->orderService->confirm($order);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new OrderResource($order);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi!');
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $status = OrderStatus::from($request->validated('status'));

        $this->authorize('updateStatus', [$order, $status]);

        $order = $this->orderService->updateStatus($order, $status);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new OrderResource($order);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
