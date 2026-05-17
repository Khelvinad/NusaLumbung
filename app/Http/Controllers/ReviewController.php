<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Order;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly ReviewService $reviewService) {}

    /**
     * Submit a review for an order.
     */
    public function store(StoreReviewRequest $request, Order $order)
    {
        $this->authorize('create', [Review::class, $order]);

        $review = $this->reviewService->store(
            $request->user(),
            $order,
            $request->validated(),
        );

        if ($request->expectsJson() || $request->is('api/*')) {
            return (new ReviewResource($review->load(['pembeli', 'petani', 'product'])))
                ->response()
                ->setStatusCode(201);
        }

        return redirect()->back()->with('success', 'Review berhasil ditambahkan!');
    }
}
