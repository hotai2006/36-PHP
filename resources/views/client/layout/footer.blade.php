<body>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer  mt-5">
        <div class="container">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="/">
                            <h1 class="text-primary mb-0">T-Sports</h1>
                            <p class="text-secondary mb-0">Quần áo thể thao cao cấp</p>
                        </a>
                    </div>
                    <div class="col-lg-3 ms-auto">
                        <div class="d-flex justify-content-lg-end justify-content-center pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Tại sao mọi người thích chúng tôi!</h4>
                        <p class="mb-4">Chúng tôi cung cấp quần áo thể thao chất lượng cao với giá cạnh tranh. Mọi sản phẩm đều được chọn lọc kỹ càng từ những thương hiệu hàng đầu thế giới. Dịch vụ giao hàng nhanh, chu đáo và chính sách bảo hành uy tín là cam kết của chúng tôi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Thông tin cửa hàng</h4>
                        <a class="btn-link" href="">Giới thiệu</a>
                        <a class="btn-link" href="">Liên hệ với chúng tôi</a>
                        <a class="btn-link" href="">Chính sách bảo mật</a>
                        <a class="btn-link" href="">Điều khoản & Điều kiện</a>
                        <a class="btn-link" href="">Chính sách trả hàng</a>
                        <a class="btn-link" href="">Câu hỏi thường gặp & Trợ giúp</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Tài khoản</h4>
                        <a class="btn-link" href="">Tài khoản của tôi</a>
                        <a class="btn-link" href="">Chi tiết cửa hàng</a>
                        <a class="btn-link" href="">Giỏ hàng</a>
                        <a class="btn-link" href="">Danh sách mong muốn</a>
                        <a class="btn-link" href="">Lịch sử đơn hàng</a>
                        <a class="btn-link" href="">Đơn hàng quốc tế</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>T-Sports
                            shop</a>, Mọi quyền được bảo lưu.</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- ============================================ -->
    <!-- 🤖 T-SPORTS INTELLIGENT CHATBOT WIDGET -->
    <!-- ============================================ -->
    <div id="tsports-chatbot-widget">
        <!-- Chat Toggle Button -->
        <button id="chatbot-toggle-btn" class="chatbot-pulse" onclick="toggleChatWindow()">
            <i class="fas fa-comment-dots"></i>
            <span class="chatbot-tooltip">Hỗ trợ trực tuyến</span>
        </button>

        <!-- Chat Window -->
        <div id="chatbot-window" class="chatbot-hidden">
            <!-- Header -->
            <div class="chatbot-header">
                <div class="chatbot-header-info">
                    <div class="chatbot-avatar-container">
                        <div class="chatbot-avatar">TS</div>
                        <span class="chatbot-online-badge"></span>
                    </div>
                    <div class="chatbot-title-container">
                        <span class="chatbot-title">T-Sports Assistant</span>
                        <span class="chatbot-subtitle">Trợ lý ảo thông minh</span>
                    </div>
                </div>
                <div class="chatbot-header-actions" style="display: flex; align-items: center; gap: 4px;">
                    <button id="chatbot-clear-btn" onclick="clearChatHistory()" title="Xóa lịch sử trò chuyện">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button id="chatbot-close-btn" onclick="toggleChatWindow()">&times;</button>
                </div>
            </div>

            <!-- Body -->
            <div id="chatbot-body" class="chatbot-body">
                <div id="chatbot-messages">
                    <!-- Messages dynamically loaded -->
                </div>
            </div>

            <!-- Input Form -->
            <form id="chatbot-input-form" class="chatbot-input-container" onsubmit="handleChatSubmit(event)">
                <input type="text" id="chatbot-input-field" placeholder="Nhập tin nhắn..." autocomplete="off" required>
                <button type="submit" id="chatbot-send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Chatbot CSS -->
    <style>
        #tsports-chatbot-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            font-family: 'Open Sans', 'Raleway', sans-serif;
        }

        #chatbot-toggle-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ec4d4c 0%, #b83534 100%);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(236, 77, 76, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        #chatbot-toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 30px rgba(236, 77, 76, 0.6);
        }

        .chatbot-pulse::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #ec4d4c;
            top: 0;
            left: 0;
            animation: chatbot-pulsing 2s infinite;
            pointer-events: none;
        }

        @keyframes chatbot-pulsing {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        .chatbot-tooltip {
            position: absolute;
            right: 75px;
            background: #333;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        #chatbot-toggle-btn:hover .chatbot-tooltip {
            opacity: 1;
            transform: translateX(0);
        }

        #chatbot-window {
            width: 380px;
            height: 500px;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: absolute;
            bottom: 80px;
            right: 0;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform-origin: bottom right;
        }

        #chatbot-window.chatbot-hidden {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
            pointer-events: none;
        }

        .chatbot-header {
            background: linear-gradient(135deg, #1e1e24 0%, #111115 100%);
            color: white;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chatbot-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chatbot-avatar-container {
            position: relative;
        }

        .chatbot-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ec4d4c;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .chatbot-online-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 11px;
            height: 11px;
            background-color: #2ec4b6;
            border: 2px solid #111115;
            border-radius: 50%;
        }

        .chatbot-title-container {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .chatbot-title {
            font-weight: 600;
            font-size: 15px;
            color: white;
        }

        .chatbot-subtitle {
            font-size: 11px;
            color: #a0a0a5;
        }

        #chatbot-clear-btn {
            background: none;
            border: none;
            color: #a0a0a5;
            font-size: 15px;
            cursor: pointer;
            padding: 4px;
            margin-right: 8px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #chatbot-clear-btn:hover {
            color: #ec4d4c;
        }

        #chatbot-close-btn {
            background: none;
            border: none;
            color: #a0a0a5;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            transition: color 0.2s;
        }

        #chatbot-close-btn:hover {
            color: white;
        }

        .chatbot-body {
            flex-grow: 1;
            padding: 16px;
            overflow-y: auto;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
        }

        #chatbot-messages {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .chatbot-message {
            max-width: 85%;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.4;
            word-break: break-word;
            animation: message-pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: left;
        }

        @keyframes message-pop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .chatbot-message.user {
            align-self: flex-end;
            background-color: #ec4d4c;
            color: white;
            border-bottom-right-radius: 2px;
            box-shadow: 0 4px 12px rgba(236, 77, 76, 0.2);
        }

        .chatbot-message.assistant {
            align-self: flex-start;
            background-color: white;
            color: #333;
            border-bottom-left-radius: 2px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .chatbot-message.assistant p {
            margin: 0 0 8px 0;
        }
        .chatbot-message.assistant p:last-child {
            margin: 0;
        }

        .chatbot-typing {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 10px 14px;
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 12px;
            border-bottom-left-radius: 2px;
            align-self: flex-start;
            width: fit-content;
        }

        .chatbot-dot {
            width: 6px;
            height: 6px;
            background-color: #888;
            border-radius: 50%;
            animation: chatbot-dot-blink 1.4s infinite both;
        }

        .chatbot-dot:nth-child(2) { animation-delay: 0.2s; }
        .chatbot-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes chatbot-dot-blink {
            0% { opacity: .2; transform: scale(0.8); }
            20% { opacity: 1; transform: scale(1.1); }
            100% { opacity: .2; transform: scale(0.8); }
        }

        .chatbot-input-container {
            padding: 12px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            display: flex;
            gap: 8px;
            background-color: white;
            margin-bottom: 0;
        }

        #chatbot-input-field {
            flex-grow: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        #chatbot-input-field:focus {
            border-color: #ec4d4c;
        }

        #chatbot-send-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #ec4d4c;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: background-color 0.2s, transform 0.1s;
        }

        #chatbot-send-btn:hover {
            background-color: #b83534;
            transform: scale(1.05);
        }

        .chatbot-products-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 8px;
            border-top: 1px dashed #eee;
            padding-top: 8px;
        }

        .chatbot-product-card {
            display: flex;
            gap: 10px;
            align-items: center;
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            padding: 6px;
            text-decoration: none;
            color: #333;
            transition: all 0.2s;
            text-align: left;
        }

        .chatbot-product-card:hover {
            background: #f7f7f7;
            border-color: #ec4d4c;
            transform: translateY(-1px);
        }

        .chatbot-product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .chatbot-product-info {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .chatbot-product-name {
            font-weight: 600;
            font-size: 12px;
            line-height: 1.2;
            margin-bottom: 2px;
            color: #333;
        }

        .chatbot-product-price {
            color: #ec4d4c;
            font-weight: bold;
            font-size: 12px;
        }
    </style>

    <!-- Chatbot JavaScript -->
    <script>
        let chatbotHistory = [];

        // Trích xuất CSRF Token
        function getCsrfToken() {
            const tokenEl = document.querySelector('meta[name="csrf-token"]');
            return tokenEl ? tokenEl.getAttribute('content') : '';
        }

        // Đóng/mở cửa sổ chat
        function toggleChatWindow() {
            const chatWin = document.getElementById('chatbot-window');
            chatWin.classList.toggle('chatbot-hidden');
            
            // Cuộn xuống cuối khi mở
            if (!chatWin.classList.contains('chatbot-hidden')) {
                const chatBody = document.getElementById('chatbot-body');
                chatBody.scrollTop = chatBody.scrollHeight;
                document.getElementById('chatbot-input-field').focus();
            }
        }

        // Xóa toàn bộ lịch sử chat
        function clearChatHistory() {
            if (confirm("Anh/chị có chắc chắn muốn xóa toàn bộ lịch sử trò chuyện?")) {
                chatbotHistory = [{
                    role: 'assistant',
                    content: 'Em chào anh/chị! Em là trợ lý ảo của T-Sports. Em có thể giúp gì cho anh/chị hôm nay ạ? 😊'
                }];
                sessionStorage.setItem('tsports_chatbot_history', JSON.stringify(chatbotHistory));
                renderHistory();
            }
        }

        // Định dạng Markdown đơn giản
        function formatMarkdown(text) {
            if (!text) return '';
            let html = text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");
            
            // Xử lý in đậm **text**
            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            
            // Xử lý xuống dòng
            html = html.replace(/\n/g, '<br>');
            
            return html;
        }

        // Khởi tạo Chatbot
        document.addEventListener('DOMContentLoaded', () => {
            // Nạp lịch sử từ sessionStorage
            const savedHistory = sessionStorage.getItem('tsports_chatbot_history');
            if (savedHistory) {
                chatbotHistory = JSON.parse(savedHistory);
            } else {
                // Khởi tạo lời chào mặc định
                chatbotHistory = [{
                    role: 'assistant',
                    content: 'Em chào anh/chị! Em là trợ lý ảo của T-Sports. Em có thể giúp gì cho anh/chị hôm nay ạ? 😊'
                }];
                sessionStorage.setItem('tsports_chatbot_history', JSON.stringify(chatbotHistory));
            }

            // Hiển thị lịch sử tin nhắn
            renderHistory();
        });

        // Hiển thị toàn bộ lịch sử tin nhắn
        function renderHistory() {
            const container = document.getElementById('chatbot-messages');
            container.innerHTML = '';
            
            chatbotHistory.forEach(msg => {
                appendMessageToUI(msg.role, msg.content, msg.products);
            });
            
            const chatBody = document.getElementById('chatbot-body');
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // Append tin nhắn vào khung chat
        function appendMessageToUI(role, content, products = null) {
            const container = document.getElementById('chatbot-messages');
            
            // Tạo bubble tin nhắn
            const msgDiv = document.createElement('div');
            msgDiv.classList.add('chatbot-message', role);
            msgDiv.innerHTML = formatMarkdown(content);

            // Nếu có đính kèm danh sách sản phẩm hoặc review
            if (products && products.length > 0) {
                if (products[0].name !== undefined) {
                    // Đây là danh sách sản phẩm
                    let productsHtml = '<div class="chatbot-products-container">';
                    products.forEach(p => {
                        productsHtml += `
                            <a href="${p.url || '/product/' + p.id}" class="chatbot-product-card" target="_blank">
                                <img src="${p.image}" class="chatbot-product-img" alt="${p.name}">
                                <div class="chatbot-product-info">
                                    <span class="chatbot-product-name">${p.name}</span>
                                    <span class="chatbot-product-price">${p.price_formatted}</span>
                                </div>
                            </a>
                        `;
                    });
                    productsHtml += '</div>';
                    msgDiv.innerHTML += productsHtml;
                } else if (products[0].comment !== undefined) {
                    // Đây là danh sách đánh giá/review
                    let reviewsHtml = '<div class="chatbot-products-container" style="max-height: 180px; overflow-y: auto;">';
                    products.forEach(r => {
                        let stars = '';
                        for (let i = 1; i <= 5; i++) {
                            stars += `<i class="fa${i <= r.rating ? 's' : 'r'} fa-star" style="color: #ffc107; font-size: 10px;"></i>`;
                        }
                        reviewsHtml += `
                            <div style="background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 8px; padding: 8px; margin-bottom: 6px; font-size: 12px; text-align: left;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-weight: 600;">
                                    <span>${r.user}</span>
                                    <div>${stars}</div>
                                </div>
                                <div style="color: #666; font-style: italic;">"${r.comment}"</div>
                                <div style="font-size: 10px; color: #999; margin-top: 4px; text-align: right;">${r.date} ${r.time}</div>
                            </div>
                        `;
                    });
                    reviewsHtml += '</div>';
                    msgDiv.innerHTML += reviewsHtml;
                }
            }

            container.appendChild(msgDiv);
        }

        // Hiển thị/ẩn hiệu ứng đang gõ
        function showTypingIndicator(show) {
            const container = document.getElementById('chatbot-messages');
            const existing = document.getElementById('chatbot-typing-indicator');
            
            if (show) {
                if (!existing) {
                    const typingDiv = document.createElement('div');
                    typingDiv.id = 'chatbot-typing-indicator';
                    typingDiv.classList.add('chatbot-typing');
                    typingDiv.innerHTML = `
                        <span class="chatbot-dot"></span>
                        <span class="chatbot-dot"></span>
                        <span class="chatbot-dot"></span>
                    `;
                    container.appendChild(typingDiv);
                    
                    const chatBody = document.getElementById('chatbot-body');
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            } else {
                if (existing) {
                    existing.remove();
                }
            }
        }

        // Xử lý gửi tin nhắn
        async function handleChatSubmit(event) {
            event.preventDefault();
            
            const inputField = document.getElementById('chatbot-input-field');
            const message = inputField.value.trim();
            if (!message) return;

            // Clear input
            inputField.value = '';

            // Thêm tin nhắn user vào lịch sử & UI
            chatbotHistory.push({ role: 'user', content: message });
            appendMessageToUI('user', message);
            sessionStorage.setItem('tsports_chatbot_history', JSON.stringify(chatbotHistory));
            
            const chatBody = document.getElementById('chatbot-body');
            chatBody.scrollTop = chatBody.scrollHeight;

            // Hiển thị hiệu ứng chờ
            showTypingIndicator(true);

            try {
                // Chuẩn bị payload gửi lên API (bỏ lời chào mặc định đầu tiên)
                const payloadHistory = chatbotHistory.slice(1, -1); 

                const response = await fetch('/api/chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        message: message,
                        history: payloadHistory
                    })
                });

                const json = await response.json();
                
                showTypingIndicator(false);

                if (json.success && json.data) {
                    const reply = json.data.content;
                    const products = json.data.products; // Có thể chứa products hoặc reviews
                    const redirectUrl = json.data.redirect_url; // Đọc URL chuyển hướng

                    // Thêm phản hồi chatbot vào lịch sử & UI
                    chatbotHistory.push({ role: 'assistant', content: reply, products: products });
                    appendMessageToUI('assistant', reply, products);
                    sessionStorage.setItem('tsports_chatbot_history', JSON.stringify(chatbotHistory));

                    // Nếu có lệnh chuyển hướng, thực hiện sau 1.5 giây
                    if (redirectUrl && redirectUrl !== 'null' && redirectUrl !== 'NULL') {
                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 1500);
                    }
                } else {
                    appendMessageToUI('assistant', 'Xin lỗi, hiện tại em đang gặp sự cố kết nối. Anh/chị vui lòng thử lại sau nhé! 🙏');
                }
            } catch (err) {
                console.error(err);
                showTypingIndicator(false);
                appendMessageToUI('assistant', 'Xin lỗi, hiện tại em đang gặp sự cố kết nối. Anh/chị vui lòng thử lại sau nhé! 🙏');
            }

            chatBody.scrollTop = chatBody.scrollHeight;
        }
    </script>
</body>