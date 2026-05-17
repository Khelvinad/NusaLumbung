<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PetaniProfile;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    /**
     * Create a review for an order and recalculate petani's rating_avg.
     */
    public function store(User $pembeli, Order $order, array $data): Review
    {
        return DB::transaction(function () use ($pembeli, $order, $data) {
            $review = Review::create([
                'order_id' => $order->id,
                'pembeli_id' => $pembeli->id,
                'petani_id' => $order->petani_id,
                'product_id' => $data['product_id'] ?? $order->items()->first()?->product_id,
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]);

            $this->recalculateRating($order->petani_id);

            return $review;
        });
    }

    /**
     * Recalculate the petani's average rating from all their reviews.
     */
    protected function recalculateRating(int $petaniId): void
    {
        $avg = Review::where('petani_id', $petaniId)->avg('rating') ?? 0;

        PetaniProfile::where('user_id', $petaniId)
            ->update(['rating_avg' => round($avg, 2)]);
    }
}
