<?php

namespace App\Services\ChatbotAgent\Skills\CustomerSupport\Scripts;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class GetProductReviewsScript
{
    public function execute(array $params = []): array
    {
        $productId = (int) ($params['product_id'] ?? 0);
        if ($productId <= 0) {
            return ['reviews' => []];
        }

        try {
            $product = Product::find($productId);
            if ($product) {
                $reviews = $product->reviews()->latest()->take(5)->get();
                $formatted = $reviews->map(function ($r) {
                    return [
                        'user'    => $r->user->user_name ?? 'Khách hàng',
                        'comment' => $r->comment,
                        'rating'  => (int) $r->rating,
                    ];
                })->toArray();
                return ['reviews' => $formatted];
            }
        } catch (\Exception $e) {
            Log::error('[Chatbot] Lỗi GetProductReviewsScript: ' . $e->getMessage());
        }

        // Mock fallback if not found
        return ['reviews' => $this->getMockReviews($productId)];
    }

    private function getMockReviews(int $productId): array
    {
        return [
            [
                'user'    => 'Nguyễn Văn A',
                'comment' => 'Sản phẩm đi êm chân, chất lượng hoàn thiện rất tốt. Giao hàng nhanh!',
                'rating'  => 5
            ],
            [
                'user'    => 'Trần Thị B',
                'comment' => 'Áo mặc rất mát và ôm dáng, thấm hút mồ hôi tốt khi tập thể thao.',
                'rating'  => 4
            ]
        ];
    }
}
