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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly OrderService $orderService) {}

    /**
     * List orders for pembeli — returns Blade view.
     */
    public function index(Request $request): View
    {
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

        return view('pembeli.orders.index', compact('orders'));
    }

    /**
     * Show single order — returns Blade view.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['items.product', 'pembeli', 'petani', 'reviews']);

        return view('pembeli.orders.show', compact('order'));
    }

    /**
     * Checkout — accepts JSON, returns JSON.
     */
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

    /**
     * Petani confirms a pending order.
     */
    public function confirm(Order $order): RedirectResponse
    {
        $this->authorize('confirm', $order);

        $this->orderService->confirm($order);

        return back()->with('success', 'Order #' . $order->id . ' berhasil dikonfirmasi.');
    }

    /**
     * Update order status (shipped/done/cancelled).
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $status = OrderStatus::from($request->validated('status'));

        $this->authorize('updateStatus', [$order, $status]);

        $this->orderService->updateStatus($order, $status);

        return back()->with('success', 'Status order #' . $order->id . ' berhasil diperbarui.');
    }
}
