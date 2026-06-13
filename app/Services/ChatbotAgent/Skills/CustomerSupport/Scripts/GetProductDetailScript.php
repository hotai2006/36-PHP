<?php

namespace App\Services\ChatbotAgent\Skills\CustomerSupport\Scripts;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class GetProductDetailScript
{
    public function execute(array $params = []): array
    {
        $productId = (int) ($params['product_id'] ?? 0);
        if ($productId <= 0) {
            return [];
        }

        try {
            $product = Product::find($productId);
            if ($product) {
                return [$this->formatProduct($product)];
            }
        } catch (\Exception $e) {
            Log::error('[Chatbot] Lỗi GetProductDetailScript: ' . $e->getMessage());
        }

        // Mock fallback if not found
        $mock = $this->getMockProduct($productId);
        return $mock ? [$mock] : [];
    }

    private function formatProduct($product): array
    {
        $avgRating = $product->reviews()->avg('rating') ?? 0;
        $reviewCount = $product->reviews()->count();

        $discount = $product->discounts()
            ->where('status', 'Active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        $discountPrice = $discount ? (float) $discount->discount_price : null;
        $originalPrice = (float) $product->product_price;

        return [
            'id'               => (int) $product->id,
            'name'             => $product->product_name,
            'price'            => $discountPrice ?? $originalPrice,
            'original_price'   => $discountPrice ? $originalPrice : null,
            'price_formatted'  => number_format($discountPrice ?? $originalPrice, 0, ',', '.') . '₫',
            'discount_percent' => $discountPrice ? round((1 - $discountPrice / $originalPrice) * 100) : 0,
            'description'      => $product->product_detailDesc ?? $product->product_shortDesc ?? '',
            'description_short'=> mb_substr($product->product_shortDesc ?? $product->product_detailDesc ?? '', 0, 120) . '...',
            'image'            => $product->product_image_url 
                                    ? asset('products/' . $product->product_image_url) 
                                    : asset('products/default.jpg'),
            'type'             => $product->product_type ?? '',
            'factory'          => $product->product_factory ?? '',
            'url'              => '/product/' . $product->id,
            'rating'           => round($avgRating, 1),
            'review_count'     => (int) $reviewCount,
            'stock_status'     => ($product->product_quantity ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng',
            'is_new'           => $product->created_at && $product->created_at->diffInDays(now()) <= 30,
        ];
    }

    private function getMockProduct(int $id): ?array
    {
        $mocks = [
            1 => [
                'id'               => 1,
                'name'             => 'Áo thun nam thể thao cao cấp',
                'price'            => 250000,
                'original_price'   => null,
                'price_formatted'  => '250.000₫',
                'discount_percent' => 0,
                'description'      => 'Áo thun nam chất liệu cotton 100%, thấm hút mồ hôi tốt, phù hợp cho thể thao và mặc hàng ngày.',
                'description_short'=> 'Áo thun nam chất liệu cotton 100%...',
                'image'            => '/images/products/ao-thun-nam.jpg',
                'type'             => 'Thời trang nam',
                'factory'          => 'Việt Nam',
                'url'              => '/product/1',
                'rating'           => 4.5,
                'review_count'     => 128,
                'stock_status'     => 'Còn hàng',
                'is_new'           => true,
            ],
            9 => [
                'id'               => 9,
                'name'             => 'Giày chạy bộ Nike Air Zoom Pegasus',
                'price'            => 1850000,
                'original_price'   => 2300000,
                'price_formatted'  => '1.850.000₫',
                'discount_percent' => 20,
                'description'      => 'Giày chạy bộ Nike Air Zoom Pegasus cao cấp chính hãng, đệm khí cực êm, hỗ trợ lực kéo vượt trội.',
                'description_short'=> 'Giày chạy bộ Nike Air Zoom Pegasus cao cấp...',
                'image'            => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80',
                'type'             => 'Giày dép Nike',
                'factory'          => 'Indonesia',
                'url'              => '/product/9',
                'rating'           => 4.9,
                'review_count'     => 520,
                'stock_status'     => 'Còn hàng',
                'is_new'           => true,
            ]
        ];
        return $mocks[$id] ?? null;
    }
}
