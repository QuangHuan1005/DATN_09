<button id="chatbot-toggle" class="chat-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
</button>

<div id="chatbot-window" class="chat-window hidden">
    <div class="chat-header">
        <div class="chat-title">
            <span class="status-dot"></span>
            <span>Mixtas AI Support</span>
        </div>
        <button id="chatbot-close" class="close-btn">&times;</button>
    </div>

    <div id="chat-messages" class="chat-body">
        <div class="message bot-msg">
            Xin chào! Tôi có thể giúp gì cho bạn về thời trang hôm nay?
        </div>
    </div>

    <div class="chat-footer">
        <input type="text" id="chat-input" placeholder="Hỏi về sản phẩm, giá..." autocomplete="off">
        <button id="chat-send">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</div>

<style>
    /* Chatbot CSS - Modern & Clean */
    :root {
        --chat-primary: #000000;
        /* Màu chủ đạo theo phong cách Mixtas (đen/trắng) */
        --chat-bg: #ffffff;
        --chat-grey: #f3f4f6;
        --chat-text: #1f2937;
    }

    /* Floating Button */
    .chat-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: var(--chat-primary);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 9999;
    }

    .chat-btn:hover {
        transform: scale(1.1);
    }

    /* Chat Window */
    .chat-window {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        height: 450px;
        background: var(--chat-bg);
        border-radius: 16px;
        box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 9999;
        transition: all 0.3s ease;
        opacity: 1;
        transform: translateY(0);
    }

    .chat-window.hidden {
        opacity: 0;
        transform: translateY(20px);
        pointer-events: none;
        visibility: hidden;
    }

    /* Header */
    .chat-header {
        background: var(--chat-primary);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Arial', sans-serif;
    }

    .chat-title {
        display: flex;
        align-items: center;
        font-weight: 600;
        font-size: 16px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #4ade80;
        /* Green dot */
        border-radius: 50%;
        margin-right: 8px;
    }

    .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        line-height: 1;
    }

    /* Body */
    .chat-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #f9fafb;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Scrollbar đẹp */
    .chat-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 3px;
    }

    /* Messages */
    .message {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .bot-msg {
        background: white;
        color: var(--chat-text);
        align-self: flex-start;
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 2px;
    }

    .user-msg {
        background: var(--chat-primary);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
    }

    /* Footer */
    .chat-footer {
        padding: 10px;
        background: white;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 10px;
    }

    #chat-input {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        outline: none;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    #chat-input:focus {
        border-color: var(--chat-primary);
    }

    #chat-send {
        background: var(--chat-primary);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    #chat-send:hover {
        background: #333;
    }

    #chat-send:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Loading dots */
    .typing-indicator {
        display: inline-flex;
        gap: 4px;
    }

    .typing-indicator span {
        width: 6px;
        height: 6px;
        background: #9ca3af;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out;
    }

    .typing-indicator span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1);
        }
    }

    /* Mobile Responsive */
    @media (max-width: 480px) {
        .chat-window {
            width: 90%;
            height: 80vh;
            bottom: 80px;
            right: 5%;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('chatbot-toggle');
        const closeBtn = document.getElementById('chatbot-close');
        const chatWindow = document.getElementById('chatbot-window');
        const sendBtn = document.getElementById('chat-send');
        const inputField = document.getElementById('chat-input');
        const messageContainer = document.getElementById('chat-messages');

        // Toggle Chat Window
        function toggleChat() {
            chatWindow.classList.toggle('hidden');
            if (!chatWindow.classList.contains('hidden')) {
                inputField.focus();
            }
        }
        toggleBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);

        // Hàm xử lý Markdown Link thành thẻ A HTML
        function formatLinks(text) {
            // Regex tìm kiếm dạng [Text](Url)
            const linkRegex = /\[([^\]]+)\]\(([^)]+)\)/g;
            return text.replace(linkRegex,
                '<a href="$2" target="_blank" style="color: blue; text-decoration: underline;">$1</a>');
        }

        // Hàm thêm tin nhắn vào giao diện
        function appendMessage(text, sender) {
            const div = document.createElement('div');
            div.classList.add('message', sender === 'user' ? 'user-msg' : 'bot-msg');
            // Nếu là tin nhắn từ Bot, xử lý link
            if (sender === 'bot') {
                div.innerHTML = formatLinks(text);
            } else {
                div.textContent = text;
            }

            messageContainer.appendChild(div);
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }

        // Hàm gửi tin nhắn
        async function sendMessage() {
            const text = inputField.value.trim();
            if (!text) return;

            // 1. Hiển thị tin nhắn user
            appendMessage(text, 'user');
            inputField.value = '';

            // 2. Hiển thị loading
            const loadingDiv = document.createElement('div');
            loadingDiv.classList.add('message', 'bot-msg');
            loadingDiv.innerHTML =
                '<div class="typing-indicator"><span></span><span></span><span></span></div>';
            messageContainer.appendChild(loadingDiv);
            messageContainer.scrollTop = messageContainer.scrollHeight;
            sendBtn.disabled = true;

            try {
                // 3. Gửi request đến Laravel
                const response = await fetch("{{ route('chatbot.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Laravel Token bảo mật
                    },
                    body: JSON.stringify({
                        message: text
                    })
                });

                const data = await response.json();

                // 4. Xóa loading và hiện câu trả lời
                messageContainer.removeChild(loadingDiv);

                // Format xuống dòng từ AI
                const formattedReply = data.reply.replace(/\n/g, '<br>');
                appendMessage(formattedReply, 'bot');

            } catch (error) {
                console.error('Error:', error);
                messageContainer.removeChild(loadingDiv);
                appendMessage('Có lỗi xảy ra, vui lòng thử lại.', 'bot');
            } finally {
                sendBtn.disabled = false;
            }
        }

        // Event Listeners
        sendBtn.addEventListener('click', sendMessage);
        inputField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });
    });
</script>
