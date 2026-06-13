<?php

namespace App\Services\ChatbotAgent\Skills\CustomerSupport\Scripts;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class SearchProductsScript
{
    private const MAX_RESULTS = 10;
    private const DEFAULT_LIMIT = 5;

    public function execute(array $params = []): array
    {
        $keyword = trim($params['keyword'] ?? '');
        $limit = min((int) ($params['limit'] ?? self::DEFAULT_LIMIT), self::MAX_RESULTS);

        // Phát hiện lọc theo giá
        $isPriceFilter = false;
        $priceLimit = null;
        $operator = null;

        if (!empty($keyword)) {
            $lowerKeyword = mb_strtolower($keyword, 'UTF-8');
            if (preg_match('/(?:dưới|thấp hơn|nhỏ hơn|duoi|thap hon|nho hon)\s*(\d+[\d\.,]*)\s*(triệu|tr|k|nghìn|ngàn|dong|đồng)?/iu', $lowerKeyword, $m)) {
                $operator = '<';
                $val = (float) str_replace(['.', ','], '', $m[1]);
                $unit = mb_strtolower($m[2] ?? '');
                if ($unit === 'triệu' || $unit === 'tr') {
                    $val *= 1000000;
                } elseif ($unit === 'k' || $unit === 'nghìn' || $unit === 'ngàn') {
                    $val *= 1000;
                } elseif ($val < 1000) {
                    $val *= 1000;
                }
                $priceLimit = $val;
                $isPriceFilter = true;
            } elseif (preg_match('/(?:trên|lớn hơn|cao hơn|tren|lon hon|cao hon)\s*(\d+[\d\.,]*)\s*(triệu|tr|k|nghìn|ngàn|dong|đồng)?/iu', $lowerKeyword, $m)) {
                $operator = '>=';
                $val = (float) str_replace(['.', ','], '', $m[1]);
                $unit = mb_strtolower($m[2] ?? '');
                if ($unit === 'triệu' || $unit === 'tr') {
                    $val *= 1000000;
                } elseif ($unit === 'k' || $unit === 'nghìn' || $unit === 'ngàn') {
                    $val *= 1000;
                } elseif ($val < 1000) {
                    if ($val <= 10) {
                        $val *= 1000000;
                    } else {
                        $val *= 1000;
                    }
                }
                $priceLimit = $val;
                $isPriceFilter = true;
            }
        }

        // Làm sạch từ khóa (chỉ thực hiện nếu không phải lọc theo giá)
        if (!$isPriceFilter && !empty($keyword)) {
            $cleanKeyword = preg_replace('/^(?:tìm|tim|search|kiếm|kiem|tìm kiếm|tim kiem|có bán|co ban|có|co|mua|xem|tôi muốn mua đồ|toi muon mua do|cho xem|cho em xem|cho toi xem)\s+/iu', '', $keyword);
            $cleanKeyword = preg_replace('/\s+(?:không|khong|nào|nao|nhỉ|nhi|ạ|a|được không|duoc khong)$/iu', '', $cleanKeyword);
            $cleanKeyword = trim($cleanKeyword);
            if (mb_strlen($cleanKeyword) > 1) {
                $keyword = $cleanKeyword;
            }
        }

        try {
            if ($isPriceFilter) {
                $products = Product::where('product_price', $operator, $priceLimit)
                    ->latest()
                    ->take($limit)
                    ->get();
            } elseif (!empty($keyword)) {
                $products = Product::where('product_name', 'like', '%' . $keyword . '%')
                    ->orWhere('product_detailDesc', 'like', '%' . $keyword . '%')
                    ->orWhere('product_shortDesc', 'like', '%' . $keyword . '%')
                    ->orWhere('product_type', 'like', '%' . $keyword . '%')
                    ->latest()
                    ->take($limit)
                    ->get();
            } else {
                $products = Product::latest()->take($limit)->get();
            }

            if ($products->isNotEmpty()) {
                return $products->map(function ($product) {
                    return $this->formatProduct($product);
                })->toArray();
            }

            Log::info('[Chatbot] DB trống hoặc không tìm thấy, sử dụng mock data cho search_products');
            return $this->getMockProducts($keyword, $limit, $isPriceFilter, $operator, $priceLimit);

        } catch (\Exception $e) {
            Log::error('[Chatbot] Lỗi search_products: ' . $e->getMessage());
            return $this->getMockProducts($keyword, $limit, $isPriceFilter, $operator, $priceLimit);
        }
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

    private function getMockProducts(string $keyword = '', int $limit = 5, bool $isPriceFilter = false, string $operator = null, float $priceLimit = null): array
    {
        $allProducts = [
            [
                'id'               => 1,
                'name'             => 'Áo thun nam thể thao cao cấp',
                'price'            => 250000,
                'original_price'   => null,
                'price_formatted'  => '250.000₫',
                'discount_percent' => 0,
                'description'      => 'Áo thun nam chất liệu cotton 100%, thấm hút mồ hôi tốt, phù hợp cho thể thao và mặc hàng ngày.',
                'description_short'=> 'Áo thun nam chất liệu cotton 100%, thấm hút mồ hôi tốt...',
                'image'            => '/images/products/ao-thun-nam.jpg',
                'type'             => 'Thời trang nam',
                'factory'          => 'Việt Nam',
                'url'              => '/product/1',
                'rating'           => 4.5,
                'review_count'     => 128,
                'stock_status'     => 'Còn hàng',
                'is_new'           => true,
            ],
            [
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
            ],
            [
                'id'               => 11,
                'name'             => 'Giày đá bóng Adidas Predator Elite',
                'price'            => 1650000,
                'original_price'   => 1950000,
                'price_formatted'  => '1.650.000₫',
                'discount_percent' => 15,
                'description'      => 'Giày đá bóng Adidas Predator Elite hỗ trợ kiểm soát bóng tối đa, đinh FG chuyên nghiệp.',
                'description_short'=> 'Giày đá bóng Adidas Predator Elite kiểm soát bóng...',
                'image'            => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=400&q=80',
                'type'             => 'Giày dép Adidas',
                'factory'          => 'Việt Nam',
                'url'              => '/product/11',
                'rating'           => 4.8,
                'review_count'     => 98,
                'stock_status'     => 'Còn hàng',
                'is_new'           => true,
            ]
        ];

        if ($isPriceFilter) {
            $results = array_filter($allProducts, function ($p) use ($operator, $priceLimit) {
                if ($operator === '>=') {
                    return $p['price'] >= $priceLimit;
                } else {
                    return $p['price'] < $priceLimit;
                }
            });
            $results = array_values($results);
        } elseif (!empty($keyword)) {
            $kw = mb_strtolower($keyword, 'UTF-8');
            $filtered = array_filter($allProducts, function ($p) use ($kw) {
                return mb_strpos(mb_strtolower($p['name'], 'UTF-8'), $kw) !== false
                    || mb_strpos(mb_strtolower($p['type'], 'UTF-8'), $kw) !== false
                    || mb_strpos(mb_strtolower($p['description'], 'UTF-8'), $kw) !== false;
            });
            $results = array_values($filtered);
        } else {
            $results = $allProducts;
        }

        return array_slice($results, 0, $limit);
    }
}
