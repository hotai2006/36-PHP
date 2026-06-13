<?php

namespace App\Services\ChatbotAgent;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * ChatbotService - Engine trung tâm của Chatbot Agent
 * 
 * Chức năng:
 * - Nạp cấu hình hệ thống (API key, model, system prompt)
 * - Đọc các file tri thức (references/*.md)
 - Tích hợp logic phát hiện ý định (Intent Detection) & Gọi công cụ (Function Calling)
 * - Gửi dữ liệu tới LLM API và nhận phản hồi
 * - Hỗ trợ đa nền tảng LLM (Google Gemini, OpenAI ChatGPT)
 * 
 * @package App\Services\ChatbotAgent
 */
class ChatbotService
{
    /**
     * Danh sách các LLM provider được hỗ trợ
     */
    private const SUPPORTED_PROVIDERS = ['gemini', 'openai'];

    /**
     * Cấu hình model mặc định
     */
    private const DEFAULT_GEMINI_MODEL = 'gemini-flash-latest';
    private const DEFAULT_OPENAI_MODEL = 'gpt-4o-mini';

    /**
     * Số lượng tin nhắn lịch sử tối đa gửi lên API
     */
    private const MAX_HISTORY_PAIRS = 8;

    // ──────────────────────────────────────────────
    //   Properties
    // ──────────────────────────────────────────────

    /** @var string LLM Provider ('gemini' hoặc 'openai') */
    protected string $provider;

    /** @var string API Key */
    protected string $apiKey;

    /** @var string Tên model */
    protected string $model;

    /** @var string System Prompt hoàn chỉnh */
    protected string $systemPrompt;

    /** @var array Nội dung các file references đã được nạp */
    protected array $references = [];

    /** @var float Nhiệt độ sáng tạo (0.0 - 1.0) */
    protected float $temperature;

    /** @var int Số token tối đa trong câu trả lời */
    protected int $maxOutputTokens;

    // ──────────────────────────────────────────────
    //   Constructor
    // ──────────────────────────────────────────────

    public function __construct()
    {
        // Đọc cấu hình từ config/services.php
        $this->provider = config('services.chatbot.provider', 'gemini');
        $this->apiKey = $this->resolveApiKey();
        $this->model = $this->resolveModel();
        $this->temperature = (float) config('services.chatbot.temperature', 0.7);
        $this->maxOutputTokens = (int) config('services.chatbot.max_tokens', 1024);

        // Nạp tri thức
        $this->loadReferences();
        $this->systemPrompt = $this->buildSystemPrompt();

        Log::info('[Chatbot] Khởi tạo thành công', [
            'provider' => $this->provider,
            'model'    => $this->model,
            'refs'     => count($this->references),
        ]);
    }

    // ──────────────────────────────────────────────
    //   Public API
    // ──────────────────────────────────────────────

    /**
     * Xử lý tin nhắn chat chính
     *
     * @param string $message Nội dung tin nhắn người dùng
     * @param array $history Lịch sử hội thoại [{role, content}, ...]
     * @return array Phản hồi chatbot
     */
    public function chat(string $message, array $history = []): array
    {
        $lower = mb_strtolower(trim($message), 'UTF-8');

        // Bước 1: Phát hiện ý định và tra cứu dữ liệu nếu cần (chạy trước để LLM có dữ liệu trả lời câu hỏi)
        $actionResult = $this->handleActions($message);

        // Bước 2: Nếu có dữ liệu tra cứu, thêm vào context
        $actionContext = $this->buildActionContext($actionResult);

        // Bước 3: Xây dựng payload và gọi LLM API
        $reply = $this->callLLM($message, $history, $actionContext);

        $redirectUrl = null;
        $content = '';
        $isFallback = false;

        // Nếu LLM lỗi (hết quota, sai key, mất mạng...)
        if (empty($reply) || str_contains($reply, 'sự cố kết nối') || str_contains($reply, 'không thể trả lời ngay bây giờ')) {
            $isFallback = true;
        } else {
            // Cố gắng parse JSON từ phản hồi LLM
            $parsed = json_decode($reply, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($parsed['content'])) {
                $content = $parsed['content'];
                $redirectUrl = $parsed['redirect_url'] ?? null;
            } else {
                // Thử tìm khối JSON {} trong chuỗi bằng regex nếu decode trực tiếp thất bại
                if (preg_match('/(\{.*\})/s', $reply, $matches)) {
                    $parsed = json_decode($matches[1], true);
                    if (json_last_error() === JSON_ERROR_NONE && isset($parsed['content'])) {
                        $content = $parsed['content'];
                        $redirectUrl = $parsed['redirect_url'] ?? null;
                    }
                }

                // Nếu vẫn không parse được, thử làm sạch markdown code block làm phương án dự phòng cuối
                if (empty($content)) {
                    $cleanReply = preg_replace('/^```(?:json)?\s+|\s+```$/', '', trim($reply));
                    $parsed = json_decode($cleanReply, true);
                    if (json_last_error() === JSON_ERROR_NONE && isset($parsed['content'])) {
                        $content = $parsed['content'];
                        $redirectUrl = $parsed['redirect_url'] ?? null;
                    } else {
                        // Nếu không phải JSON, coi toàn bộ câu trả lời là content
                        $content = $reply;
                    }
                }
            }
        }

        // Đệ quy giải mã nếu content bị double-wrapped dưới dạng chuỗi JSON
        while (is_string($content) && (str_starts_with(trim($content), '{') || str_starts_with(trim($content), '['))) {
            $doubleParsed = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($doubleParsed['content'])) {
                $content = $doubleParsed['content'];
                if (isset($doubleParsed['redirect_url']) && empty($redirectUrl)) {
                    $redirectUrl = $doubleParsed['redirect_url'];
                }
            } else {
                break;
            }
        }

        // Nếu sau tất cả các bước, content vẫn chứa JSON thô hoặc bị cắt cụt (ví dụ: {"content":...)
        if (is_string($content) && str_contains($content, '"content"')) {
            $content = $this->cleanTruncatedJson($content);
        }

        // Bước 4: Chạy cơ chế fallback ngoại tuyến thông minh khi LLM bị lỗi hoặc trả về rỗng
        if ($isFallback || empty($content)) {
            $redirectUrl = $this->checkNavigationIntent($lower);
            if ($redirectUrl) {
                $content = "Dạ, em đang chuyển hướng anh/chị đến trang yêu cầu...";
            } else {
                $content = $this->generateFallbackResponse($message, $actionResult);
            }
        }

        // Bước 5: Chuẩn hóa redirect_url để tránh việc chuyển hướng sang chữ "null"
        if ($redirectUrl === null || $redirectUrl === 'null' || $redirectUrl === 'NULL' || empty(trim((string)$redirectUrl))) {
            $redirectUrl = null;
        }

        // Bước 6: Trả về kết quả
        return [
            'role'          => 'assistant',
            'content'       => $content,
            'redirect_url'  => $redirectUrl,
            'has_data'      => $actionResult !== null,
            'products'      => $actionResult['products'] ?? ($actionResult['reviews'] ?? null),
            'provider'      => $this->provider,
            'model'         => $this->model,
        ];
    }

    // ──────────────────────────────────────────────
    //   Intent Detection & Function Calling
    // ──────────────────────────────────────────────

    /**
     * Phát hiện ý định điều hướng trang web
     *
     * @param string $lower Tin nhắn đã viết thường
     * @return string|null
     */
    protected function checkNavigationIntent(string $lower): ?string
    {
        // Nếu là câu hỏi hướng dẫn/cách thức, không tự động chuyển hướng trong fallback
        if (preg_match('/(?:cách|làm sao|làm thế nào|hướng dẫn|huong dan|như thế nào|nhu the nao)/iu', $lower)) {
            return null;
        }

        if (preg_match('/(?:đăng nhập|dang nhap|login)/iu', $lower)) {
            return '/login';
        }
        if (preg_match('/(?:quên mật khẩu|quen mat khau)/iu', $lower)) {
            return '/forgot-password';
        }
        if (preg_match('/(?:đăng ký|dang ky|register)/iu', $lower)) {
            return '/register';
        }
        if (preg_match('/(?:giỏ hàng|gio hang|cart)/iu', $lower)) {
            return '/cart';
        }
        if (preg_match('/(?:thanh toán|thanh toan|checkout)/iu', $lower)) {
            return '/checkout';
        }
        if (preg_match('/(?:tài khoản|tai khoan|profile|thông tin cá nhân)/iu', $lower)) {
            return '/user-profile';
        }
        if (preg_match('/(?:đơn hàng|don hang|order|lịch sử mua)/iu', $lower)) {
            return '/order-history';
        }
        if (preg_match('/(?:yêu thích|yeu thich|favorite|quan tâm)/iu', $lower)) {
            return '/favorites';
        }
        if (preg_match('/(?:trang chủ|trang chu|home)/iu', $lower)) {
            return '/';
        }
        // Nhận diện tìm kiếm thương hiệu/sản phẩm (ví dụ: "mua đồ nike", "tìm giày adidas")
        if (preg_match('/(?:mua|tìm|tim|kiếm|kiem|xem)\s+(?:đồ|giày|áo|quần|vợt)?\s*(nike|adidas|puma|lining|mizuno|yonex)/iu', $lower, $m)) {
            return '/product?searchValue=' . urlencode(trim($m[1]));
        }
        return null;
    }

    /**
     * Phát hiện ý định từ tin nhắn và gọi tool tương ứng
     *
     * @param string $message Tin nhắn người dùng
     * @return array|null Kết quả tra cứu hoặc null nếu không cần
     */
    protected function handleActions(string $message): ?array
    {
        $lower = mb_strtolower(trim($message), 'UTF-8');

        // ── Intent: Tìm kiếm sản phẩm ──
        // Pattern: "tìm [từ khóa]", "search [từ khóa]", "có bán [từ khóa] không"
        if (preg_match('/^(?:tìm|search|kiếm|tìm kiếm|có bán|có)\s+(.+?)(?:\s*không)?\s*$/iu', $lower, $m)) {
            $keyword = trim($m[1]);
            if (mb_strlen($keyword) > 1) {
                return $this->safeRunScript('search_products', ['keyword' => $keyword]);
            }
        }

        // ── Intent: Xem tất cả sản phẩm / sản phẩm mới ──
        if (preg_match('/(?:có gì mới|hàng mới|new|sản phẩm|products?|xem sản phẩ|cho (?:em|tôi) xem|danh sách|tất cả|bán gì)/iu', $lower)) {
            return $this->safeRunScript('search_products', ['keyword' => '']);
        }

        // ── Intent: Chi tiết sản phẩm ──
        // Pattern: "sản phẩm số X", "sp X", "chi tiết sản phẩm X", "thông tin sp X"
        if (preg_match('/(?:sản phẩm|sp|sản phẩm số)\s*(?:số|#)?\s*(\d+)/iu', $lower, $m)) {
            $id = (int) $m[1];
            if ($id > 0) {
                return $this->safeRunScript('get_product_detail', ['product_id' => $id]);
            }
        }

        // ── Intent: Đánh giá sản phẩm ──
        // Pattern: "đánh giá sản phẩm X", "review sp X", "sao sp X"
        if (preg_match('/(?:đánh giá|review|nhận xét|chất lượng|sao)\s*(?:sản phẩm|sp)?\s*(?:số|#)?\s*(\d+)/iu', $lower, $m)) {
            $id = (int) $m[1];
            if ($id > 0) {
                return $this->safeRunScript('get_product_reviews', ['product_id' => $id]);
            }
        }

        // ── Intent: Tìm theo giá ──
        // Pattern: "dưới X đồng", "trên Y", "khoảng Z"
        if (preg_match('/(?:dưới|trên|khoảng|giá từ|từ)\s*(\d+[\d\.]*)\s*(?:nghìn|k|triệu|tr|đồng)?/iu', $lower, $m)) {
            return $this->safeRunScript('search_products', ['keyword' => $lower]);
        }

        // ── Intent mặc định: Tìm kiếm sản phẩm nếu không phải chào hỏi hay chính sách ──
        $isGreeting = preg_match('/^(?:chào|chao|hi|hello|xin chào|xin chao|alo|helo|hey|ê|e)\s*$/iu', $lower);
        $isPolicy = preg_match('/(?:giao hàng|giao hang|vận chuyển|van chuyen|ship|đổi trả|doi tra|bảo hành|bao hanh|hoàn tiền|hoan tien|trả hàng|tra hang|chính sách|chinh sach|địa chỉ|dia chi|cửa hàng|cua hang|sđt|hotline|liên hệ|lien he)/iu', $lower);
        $isNavigation = preg_match('/(?:đăng nhập|dang nhap|login|đăng ký|dang ky|register|giỏ hàng|gio hang|cart|thanh toán|thanh toan|checkout|tài khoản|tai khoan|profile|đơn hàng|don hang|order|yêu thích|yeu thich|favorite|trang chủ|trang chu|home|quên mật khẩu|quen mat khau)/iu', $lower);

        if (!$isGreeting && !$isPolicy && !$isNavigation && mb_strlen($lower) > 1) {
            return $this->safeRunScript('search_products', ['keyword' => $lower]);
        }

        return null;
    }

    /**
     * Chạy script an toàn với try-catch
     *
     * @param string $name Tên script
     * @param array $params Tham số
     * @return array|null
     */
    protected function safeRunScript(string $name, array $params = []): ?array
    {
        try {
            return $this->runScript($name, $params);
        } catch (Exception $e) {
            Log::error("[Chatbot] Lỗi khi chạy script [{$name}]: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Gọi script tương ứng với action
     *
     * @param string $name Tên script (không có hậu tố Script)
     * @param array $params Tham số truyền vào
     * @return array|null
     */
    protected function runScript(string $name, array $params = []): ?array
    {
        // Map tên script → class tương ứng
        $classMap = [
            'search_products'     => \App\Services\ChatbotAgent\Skills\CustomerSupport\Scripts\SearchProductsScript::class,
            'get_product_detail'  => \App\Services\ChatbotAgent\Skills\CustomerSupport\Scripts\GetProductDetailScript::class,
            'get_product_reviews' => \App\Services\ChatbotAgent\Skills\CustomerSupport\Scripts\GetProductReviewsScript::class,
        ];

        $className = $classMap[$name] ?? null;

        if (!$className || !class_exists($className)) {
            Log::warning("[Chatbot] Script [{$name}] không tồn tại hoặc class $className không tìm thấy");
            return null;
        }

        // Khởi tạo và thực thi script
        $script = new $className();
        $result = $script->execute($params);

        // Kiểm tra kết quả rỗng
        if (empty($result) || (is_array($result) && empty(array_filter($result, fn($v) => !empty($v))))) {
            return ['message' => 'Không tìm thấy kết quả phù hợp.', 'products' => []];
        }

        // Nếu kết quả có reviews (từ get_product_reviews), trả về nguyên bản
        if (isset($result['reviews'])) {
            return $result;
        }

        return ['products' => $result];
    }

    /**
     * Xây dựng context string từ kết quả action
     *
     * @param array|null $actionResult
     * @return string
     */
    protected function buildActionContext(?array $actionResult): string
    {
        if ($actionResult === null) {
            return '';
        }

        $context = "\n\n[DỮ LIỆU TRA CỨU TỪ CỬA HÀNG]\n";
        $context .= json_encode($actionResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $context .= "\n[/DỮ LIỆU TRA CỨU]\n";

        // Hướng dẫn LLM cách dùng dữ liệu
        $context .= "\n💡 Hướng dẫn: Hãy sử dụng dữ liệu trên để trả lời khách hàng một cách tự nhiên, thân thiện bằng tiếng Việt.\n";
        $context .= "- Nếu là danh sách sản phẩm: giới thiệu 2-3 sản phẩm nổi bật.\n";
        $context .= "- Nếu là chi tiết sản phẩm: nêu tên, giá, mô tả ngắn và điểm nổi bật.\n";
        $context .= "- Nếu là đánh giá: nêu điểm trung bình và trích dẫn 1-2 đánh giá tiêu biểu.\n";
        $context .= "- KHÔNG đọc nguyên văn JSON cho khách hàng.\n";

        return $context;
    }

    // ──────────────────────────────────────────────
    //   LLM Integration
    // ──────────────────────────────────────────────

    /**
     * Gọi LLM API và nhận phản hồi
     *
     * @param string $message Tin nhắn người dùng
     * @param array $history Lịch sử hội thoại
     * @param string $actionContext Context từ action (nếu có)
     * @return string Phản hồi chatbot
     */
    protected function callLLM(string $message, array $history, string $actionContext = ''): string
    {
        // Kết hợp tin nhắn user với context
        $userContent = $message;
        if ($actionContext) {
            $userContent = $message . "\n" . $actionContext;
        }

        try {
            // Chọn provider và gọi API
            return match ($this->provider) {
                'openai' => $this->callOpenAI($message, $history, $actionContext),
                default  => $this->callGemini($message, $history, $actionContext),
            };
        } catch (Exception $e) {
            Log::error("[Chatbot] Lỗi LLM API: " . $e->getMessage());
            return 'Xin lỗi, hiện tại em đang gặp sự cố kết nối. Anh/chị vui lòng thử lại sau ít phút nữa nhé! 🙏';
        }
    }

    /**
     * Tạo câu trả lời fallback tại local khi LLM gặp sự cố (rate limit / lỗi kết nối)
     *
     * @param string $message Tin nhắn người dùng
     * @param array|null $actionResult Kết quả từ việc chạy script intent
     * @return string
     */
    protected function generateFallbackResponse(string $message, ?array $actionResult): string
    {
        $lower = mb_strtolower(trim($message), 'UTF-8');

        // 1. Nếu có kết quả tìm kiếm sản phẩm từ Database
        if ($actionResult !== null && isset($actionResult['products'])) {
            $products = $actionResult['products'];
            if (!empty($products)) {
                $count = count($products);
                $reply = "Dạ, hiện tại dịch vụ AI đang bận hoặc quá tải, nhưng em đã tìm thấy **{$count} sản phẩm** phù hợp với yêu cầu của anh/chị tại cửa hàng:\n\n";
                
                $showCount = min(3, $count);
                for ($i = 0; $i < $showCount; $i++) {
                    $p = $products[$i];
                    $priceStr = isset($p['price_formatted']) ? $p['price_formatted'] : number_format($p['price']) . 'đ';
                    $reply .= "- **{$p['name']}**: Giá {$priceStr}\n";
                }
                if ($count > 3) {
                    $reply .= "\n*(Anh/chị có thể xem danh sách đầy đủ ở các thẻ sản phẩm bên dưới)*\n";
                }
                $reply .= "\nAnh/chị có thể click vào các sản phẩm bên dưới để xem chi tiết và đặt mua ạ! 😊";
                return $reply;
            }
        }

        // 2. Nếu có đánh giá sản phẩm từ Database
        if ($actionResult !== null && isset($actionResult['reviews'])) {
            $reviews = $actionResult['reviews'];
            if (!empty($reviews)) {
                $count = count($reviews);
                $reply = "Dạ, hiện tại dịch vụ AI đang bận, nhưng em tìm thấy **{$count} đánh giá** cho sản phẩm này:\n\n";
                
                $totalStars = 0;
                foreach ($reviews as $r) {
                    $totalStars += $r['rating'] ?? 5;
                }
                $avg = round($totalStars / $count, 1);
                $reply .= "⭐️ Điểm đánh giá trung bình: **{$avg}/5 sao**\n\n";
                $reply .= "Dưới đây là một số đánh giá tiêu biểu:\n";
                $showCount = min(2, $count);
                for ($i = 0; $i < $showCount; $i++) {
                    $r = $reviews[$i];
                    $reply .= "- **{$r['user']}**: \"{$r['comment']}\" ({$r['rating']}⭐️)\n";
                }
                return $reply;
            }
        }

        // 3. Nếu khách hỏi chính sách vận chuyển / giao hàng
        if (preg_match('/(?:vận chuyển|ship|giao hàng|giao hang|phí ship|gui hang|gửi hàng)/iu', $lower)) {
            return "Dạ, về **chính sách giao hàng**, T-Sports hỗ trợ giao hàng toàn quốc:\n\n- **Thời gian giao hàng:** Nội thành 1-2 ngày, ngoại thành 3-5 ngày.\n- **Phí giao hàng:** Đồng giá 30.000đ toàn quốc. Miễn phí vận chuyển cho đơn hàng từ 1.000.000đ trở lên.\n\nAnh/chị có thể xem thêm chi tiết trong chính sách của shop nhé! 😊";
        }

        // 4. Nếu khách hỏi chính sách đổi trả / bảo hành
        if (preg_match('/(?:đổi trả|doi tra|hoàn tiền|hoan tien|trả hàng|tra hang|bảo hành|bao hanh)/iu', $lower)) {
            return "Dạ, về **chính sách đổi trả**, T-Sports hỗ trợ khách hàng đổi trả sản phẩm trong vòng **7 ngày** kể từ ngày nhận hàng với điều kiện:\n\n- Sản phẩm còn nguyên tag mác, chưa qua sử dụng.\n- Đổi size hoặc đổi sản phẩm khác bằng hoặc cao giá hơn.\n\nAnh/chị cần hỗ trợ đổi trả vui lòng mang theo hóa đơn hoặc liên hệ hotline cửa hàng ạ! 😊";
        }

        // 5. Nếu khách hỏi địa chỉ / cửa hàng / liên hệ / hotline / sđt
        if (preg_match('/(?:địa chỉ|dia chi|ở đâu|o dau|cửa hàng|cua hang|shop ở|hotline|sđt|sdt|liên hệ|lien he)/iu', $lower)) {
            return "Dạ, cửa hàng **T-Sports** chuyên cung cấp quần áo và giày thể thao cao cấp có địa chỉ tại:\n\n📍 **280 Đường An Dương Vương, Phường 4, Quận 5, TP. Hồ Chí Minh**\n📞 **Hotline:** 1900 xxxx\n⏰ **Giờ mở cửa:** 8:00 - 22:00 tất cả các ngày trong tuần (kể cả lễ, Tết).\n\nRất mong được đón tiếp anh/chị đến tham quan và mua sắm tại cửa hàng ạ! 😊";
        }

        // 6. Nếu khách chào hỏi
        if (preg_match('/^(?:chào|chao|hi|hello|xin chào|xin chao|alo|hey|ê|e)\s*$/iu', $lower)) {
            return "Dạ T-Sports xin chào anh/chị! Em có thể giúp gì cho anh/chị hôm nay ạ? Anh/chị có thể hỏi em về các sản phẩm thể thao hoặc các chính sách vận chuyển, đổi trả của shop nhé! 😊";
        }

        // 7. Nếu không khớp ý định cụ thể nào
        return "Dạ, hiện tại hệ thống AI đang gặp sự cố kết nối (quá tải hạn mức API). Tuy nhiên, anh/chị vẫn có thể:\n\n1. 🔍 **Tìm kiếm sản phẩm:** Nhập \"tìm giày\", \"tìm áo nike\"...\n2. 📦 **Hỏi chính sách:** Nhập \"chính sách giao hàng\", \"chính sách đổi trả\"...\n\nNếu cần hỗ trợ gấp, anh/chị vui lòng liên hệ hotline **1900 xxxx** hoặc fanpage để được tư vấn ngay lập tức nhé! Em xin lỗi vì sự bất tiện này ạ! 🙏";
    }

    /**
     * Gọi Google Gemini API
     */
    protected function callGemini(string $message, array $history, string $actionContext = ''): string
    {
        $userContent = $message . ($actionContext ? "\n" . $actionContext : '');

        // Xây dựng contents array
        $contents = [];

        // Lấy lịch sử gần nhất
        $recentHistory = array_slice($history, -self::MAX_HISTORY_PAIRS * 2);
        foreach ($recentHistory as $msg) {
            if (!isset($msg['role'], $msg['content'])) continue;
            $geminiRole = ($msg['role'] === 'assistant') ? 'model' : 'user';
            $contents[] = [
                'role'  => $geminiRole,
                'parts' => [['text' => $msg['content']]],
            ];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $userContent]]];

        $base = config('services.chatbot.api_base');
        $url = ($base ? rtrim($base, '/') : 'https://generativelanguage.googleapis.com') . "/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $response = Http::timeout(60)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, [
                'system_instruction' => [
                    'parts' => [['text' => $this->systemPrompt]],
                ],
                'contents'    => $contents,
                'generationConfig' => [
                    'temperature'       => $this->temperature,
                    'maxOutputTokens'   => $this->maxOutputTokens,
                    'topK'              => 40,
                    'topP'              => 0.95,
                    'responseMimeType'  => 'application/json',
                    'responseSchema'    => [
                        'type' => 'OBJECT',
                        'properties' => [
                            'content' => [
                                'type' => 'STRING',
                                'description' => 'Lời phản hồi thân thiện của tư vấn viên gửi đến khách hàng (bằng tiếng Việt, có icon cảm xúc, định dạng Markdown).'
                            ],
                            'redirect_url' => [
                                'type' => 'STRING',
                                'description' => 'Đường dẫn chuyển hướng (ví dụ: /register, /login, /product?searchValue=nike) hoặc null. CHỈ điền khi người dùng đưa ra yêu cầu/mệnh lệnh trực tiếp muốn chuyển trang ngay lập tức. Đối với câu hỏi hỏi han, hỏi cách thức ("làm thế nào để...", "cách đăng ký..."), TUYỆT ĐỐI đặt là null.'
                            ]
                        ],
                        'required' => ['content', 'redirect_url']
                    ]
                ],
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HARASSMENT',     'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH',    'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE'],
                ],
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text']
                ?? 'Xin lỗi, em không thể trả lời ngay bây giờ. Anh/chị vui lòng thử lại sau nhé! 🙏';
        }

        Log::warning('[Chatbot] Gemini API lỗi', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);
        return 'Xin lỗi, hiện tại em đang gặp sự cố kết nối. Anh/chị vui lòng thử lại sau ít phút nữa nhé! 🙏';
    }

    /**
     * Gọi OpenAI ChatGPT API
     */
    protected function callOpenAI(string $message, array $history, string $actionContext = ''): string
    {
        $userContent = $message . ($actionContext ? "\n" . $actionContext : '');

        // Xây dựng messages array
        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt],
        ];

        // Thêm lịch sử
        $recentHistory = array_slice($history, -self::MAX_HISTORY_PAIRS * 2);
        foreach ($recentHistory as $msg) {
            if (isset($msg['role'], $msg['content'])) {
                $messages[] = [
                    'role'    => $msg['role'],
                    'content' => $msg['content'],
                ];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $userContent];

        $base = config('services.chatbot.api_base');
        $url = ($base ? rtrim($base, '/') : 'https://api.openai.com') . '/v1/chat/completions';

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])
            ->post($url, [
                'model'       => $this->model,
                'messages'    => $messages,
                'temperature' => $this->temperature,
                'max_tokens'  => $this->maxOutputTokens,
                'response_format' => [
                    'type' => 'json_schema',
                    'json_schema' => [
                        'name' => 'chatbot_response',
                        'strict' => true,
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'content' => [
                                    'type' => 'string',
                                    'description' => 'Lời phản hồi thân thiện của tư vấn viên gửi đến khách hàng (bằng tiếng Việt, có icon cảm xúc, định dạng Markdown).'
                                ],
                                'redirect_url' => [
                                    'type' => ['string', 'null'],
                                    'description' => 'Đường dẫn chuyển hướng (ví dụ: /register, /login, /product?searchValue=nike) hoặc null. CHỈ điền khi người dùng đưa ra yêu cầu/mệnh lệnh trực tiếp muốn chuyển trang ngay lập tức. Đối với câu hỏi hỏi han, hỏi cách thức ("làm thế nào để...", "cách đăng ký..."), TUYỆT ĐỐI đặt là null.'
                                ]
                            ],
                            'required' => ['content', 'redirect_url'],
                            'additionalProperties' => false
                        ]
                    ]
                ],
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['choices'][0]['message']['content']
                ?? 'Xin lỗi, em không thể trả lời ngay bây giờ. Anh/chị vui lòng thử lại sau nhé! 🙏';
        }

        Log::warning('[Chatbot] OpenAI API lỗi', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);
        return 'Xin lỗi, hiện tại em đang gặp sự cố kết nối. Anh/chị vui lòng thử lại sau ít phút nữa nhé! 🙏';
    }

    // ──────────────────────────────────────────────
    //   System Prompt & References
    // ──────────────────────────────────────────────

    /**
     * Nạp nội dung các file references (kiến thức nền tảng)
     */
    protected function loadReferences(): void
    {
        $refDir = __DIR__ . '/Skills/CustomerSupport/References/';

        if (!is_dir($refDir)) {
            Log::warning("[Chatbot] Thư mục references không tồn tại: {$refDir}");
            return;
        }

        $files = glob($refDir . '*.md');
        if (empty($files)) {
            Log::warning("[Chatbot] Không tìm thấy file .md nào trong: {$refDir}");
            return;
        }

        foreach ($files as $file) {
            $content = file_get_contents($file);
            if ($content !== false && !empty(trim($content))) {
                $this->references[basename($file)] = $content;
            }
        }

        Log::info('[Chatbot] Đã nạp references', [
            'files' => array_keys($this->references),
        ]);
    }

    /**
     * Xây dựng System Prompt hoàn chỉnh
     * Kết hợp SKILL.md + nội dung references
     *
     * @return string
     */
    protected function buildSystemPrompt(): string
    {
        // Đọc SKILL.md - file định nghĩa tính cách và quy tắc
        $skillPath = __DIR__ . '/Skills/CustomerSupport/SKILL.md';
        $skillContent = '';
        if (file_exists($skillPath)) {
            $skillContent = file_get_contents($skillPath);
        } else {
            Log::warning('[Chatbot] File SKILL.md không tồn tại');
        }

        // Ghép nội dung các references
        $refsContent = '';
        foreach ($this->references as $name => $content) {
            $refsContent .= "\n\n---\n### 📄 File: {$name}\n{$content}";
        }

        // System Prompt hoàn chỉnh
        return <<<PROMPT
{$skillContent}

## 📚 CHÍNH SÁCH CỬA HÀNG (Tham khảo khi trả lời)
{$refsContent}

## ⚙️ QUY TẮC HOẠT ĐỘNG
1. **Ngôn ngữ:** Luôn trả lời bằng tiếng Việt, sử dụng icon cảm xúc 😊 👍 🎉
2. **Xưng hô:** Em - Anh/Chị (thân thiện, lịch sự)
3. **Có dữ liệu tra cứu:** Khi có thẻ [DỮ LIỆU TRA CỨU TỪ CỬA HÀNG], hãy dùng nó làm nguồn dữ liệu chính xác để trả lời khách
4. **Không có dữ liệu tra cứu:** Dùng kiến thức trong file references ở trên
5. **Giới thiệu sản phẩm:** Khi khách hỏi "có gì mới" hoặc "sản phẩm", giới thiệu 2-3 sản phẩm nổi bật
6. **Chính sách:** Khi khách hỏi về chính sách (đổi trả, ship, thanh toán), đọc từ file tham khảo bên trên
7. **Kết thúc:** Luôn mời khách hỏi thêm hoặc xem chi tiết sản phẩm
8. **⚠️ NGHIÊM CẤM:** Tự ý tạo ra thông tin sai lệch về giá cả, chính sách. Nếu không chắc chắn, nói:
   "Em chưa có thông tin về vấn đề này, anh/chị vui lòng liên hệ hotline 1900xxxx để được hỗ trợ ạ! 🙏"
9. **Bảo mật:** KHÔNG yêu cầu khách cung cấp mật khẩu, OTP, thông tin thẻ ngân hàng
PROMPT;
    }

    // ──────────────────────────────────────────────
    //   Configuration Helpers
    // ──────────────────────────────────────────────

    /**
     * Lấy API key tương ứng với provider
     *
     * @return string
     */
    protected function resolveApiKey(): string
    {
        return match ($this->provider) {
            'openai' => config('services.openai.api_key', ''),
            default  => config('services.gemini.api_key', ''),
        };
    }

    /**
     * Lấy tên model tương ứng với provider
     *
     * @return string
     */
    protected function resolveModel(): string
    {
        return match ($this->provider) {
            'openai' => config('services.chatbot.model', self::DEFAULT_OPENAI_MODEL),
            default  => config('services.chatbot.model', self::DEFAULT_GEMINI_MODEL),
        };
    }

    /**
     * Kiểm tra cấu hình chatbot đã sẵn sàng chưa
     *
     * @return array ['ready' => bool, 'missing' => array]
     */
    public function healthCheck(): array
    {
        $missing = [];

        if (empty($this->apiKey)) {
            $missing[] = "API Key cho provider [{$this->provider}]";
        }

        if (empty($this->systemPrompt)) {
            $missing[] = 'System Prompt (kiểm tra SKILL.md và references)';
        }

        return [
            'ready'   => empty($missing),
            'missing' => $missing,
            'config'  => [
                'provider' => $this->provider,
                'model'    => $this->model,
                'refs'     => count($this->references),
            ],
        ];
    }

    /**
     * Làm sạch và trích xuất nội dung văn bản từ một chuỗi JSON bị cắt cụt (truncated JSON)
     *
     * @param string $reply Chuỗi JSON bị cắt cụt (ví dụ: {"content":"Dạ, T-Sports...)
     * @return string
     */
    protected function cleanTruncatedJson(string $reply): string
    {
        if (preg_match('/"content"\s*:\s*"(.*)/s', $reply, $m)) {
            $content = $m[1];
            
            // Tìm ký tự " đóng vai trò là dấu nháy kép đóng không bị escape
            $cleanContent = '';
            $len = strlen($content);
            $isEscaped = false;
            for ($i = 0; $i < $len; $i++) {
                $char = $content[$i];
                if ($isEscaped) {
                    $cleanContent .= $char;
                    $isEscaped = false;
                } else if ($char === '\\') {
                    $cleanContent .= $char;
                    $isEscaped = true;
                } else if ($char === '"') {
                    break;
                } else {
                    $cleanContent .= $char;
                }
            }
            
            // Unescape chuỗi JSON
            $jsonStr = '"' . $cleanContent . '"';
            $decoded = json_decode($jsonStr);
            if ($decoded !== null) {
                return $decoded;
            }
            
            return stripslashes($cleanContent);
        }
        return $reply;
    }
}
