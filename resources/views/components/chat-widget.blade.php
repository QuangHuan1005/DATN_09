<style>
    :root {
        --chat-primary: #000000;
        --chat-bg: #ffffff;
        --chat-border: #e0e0e0;
        --font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    /* Launcher */
    .chat-launcher {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 56px;
        height: 56px;
        background: var(--chat-primary);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .chat-launcher:hover { transform: translateY(-2px); }
    
    .chat-launcher svg { position: absolute; transition: all 0.3s ease; }
    .chat-launcher .icon-close { opacity: 0; transform: scale(0.5) rotate(-45deg); }
    .chat-launcher.active .icon-chat { opacity: 0; transform: scale(0.5) rotate(45deg); }
    .chat-launcher.active .icon-close { opacity: 1; transform: scale(1) rotate(0); }

    /* Window */
    .chat-window {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 340px;
        height: 480px;
        max-height: 80vh;
        background: var(--chat-bg);
        border: 1px solid var(--chat-border);
        border-radius: 4px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        z-index: 9998;
        font-family: var(--font-family);
        opacity: 0; visibility: hidden; transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .chat-window.open { opacity: 1; visibility: visible; transform: translateY(0); }

    /* Header */
    .chat-header {
        background: var(--chat-primary);
        color: white;
        padding: 16px 20px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .brand-title { font-weight: 700; font-size: 14px; text-transform: uppercase; }
    .status-indicator { font-size: 11px; opacity: 0.8; display: flex; align-items: center; gap: 6px; }
    .dot { width: 6px; height: 6px; background: #2ecc71; border-radius: 50%; }

    /* Header Actions (Nút Reset & Minimize) */
    .header-actions { display: flex; gap: 10px; align-items: center; }
    .header-btn {
        background: none; border: none; cursor: pointer; padding: 4px;
        color: white; opacity: 0.7; transition: opacity 0.2s;
        display: flex; align-items: center; justify-content: center;
    }
    .header-btn:hover { opacity: 1; }

    /* Body */
    .chat-body {
        flex: 1; padding: 20px; overflow-y: auto; background: #f9f9f9;
        display: flex; flex-direction: column; gap: 15px;
    }
    .message { max-width: 85%; padding: 12px 16px; font-size: 14px; line-height: 1.5; }
    .bot-msg { background: white; color: black; border: 1px solid #eee; border-radius: 2px 12px 12px 12px; }
    .user-msg { background: black; color: white; align-self: flex-end; border-radius: 12px 2px 12px 12px; }
    .bot-msg a { color: #000; font-weight: bold; text-decoration: underline; }

    /* Footer */
    .chat-footer { padding: 15px 20px; background: white; border-top: 1px solid #eee; }
    .input-container {
        display: flex; align-items: center; border: 1px solid #ddd;
        padding: 4px 4px 4px 15px; border-radius: 2px; background: white;
    }
    .input-container:focus-within { border-color: black; }
    #chat-input { flex: 1; border: none; outline: none; font-size: 14px; padding: 8px 0; }
    #chat-send {
        background: black; color: white; border: none; width: 36px; height: 36px;
        border-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center;
    }
    #chat-send:disabled { background: #ccc; cursor: not-allowed; }
    
    @media (max-width: 480px) {
        .chat-window { width: 100%; height: 100%; bottom: 0; right: 0; border-radius: 0; max-height: 100vh; }
    }
</style>

<button id="chatbot-toggle" class="chat-launcher">
    <svg class="icon-chat" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
    <svg class="icon-close" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
</button>

<div id="chatbot-window" class="chat-window">
    <div class="chat-header">
        <div>
            <div class="brand-title">FR/DAY SUPPORT</div>
            <div class="status-indicator"><span class="dot"></span> Online</div>
        </div>
        <div class="header-actions">
            <button id="chatbot-reset" class="header-btn" title="Xóa lịch sử chat">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
            <button id="chatbot-minimize" class="header-btn" title="Thu nhỏ">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
        </div>
    </div>
    <div id="chat-messages" class="chat-body">
        </div>
    <div class="chat-footer">
        <div class="input-container">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off">
            <button id="chat-send" disabled>
                Gửi
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('chatbot-toggle');
        const minimizeBtn = document.getElementById('chatbot-minimize');
        const resetBtn = document.getElementById('chatbot-reset'); // Lấy nút Reset
        const chatWindow = document.getElementById('chatbot-window');
        const sendBtn = document.getElementById('chat-send');
        const inputField = document.getElementById('chat-input');
        const messageContainer = document.getElementById('chat-messages');
        
        const STORAGE_KEY = 'mixtas_chat_history';
        const STATE_KEY = 'mixtas_chat_open';
        const DEFAULT_MSG = "Xin chào! Bạn cần tìm sản phẩm nào hôm nay?";

        // --- Các hàm hỗ trợ ---

        function saveMessage(text, sender) {
            let history = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '[]');
            history.push({ text, sender });
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify(history));
        }

        function scrollToBottom() { messageContainer.scrollTop = messageContainer.scrollHeight; }

        function renderMessage(text, sender) {
            const div = document.createElement('div');
            div.classList.add('message', sender === 'user' ? 'user-msg' : 'bot-msg');
            if (sender === 'bot') {
                div.innerHTML = text.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2">$1</a>').replace(/\n/g, '<br>');
            } else {
                div.textContent = text;
            }
            messageContainer.appendChild(div);
            scrollToBottom();
        }

        function checkInput() {
            sendBtn.disabled = inputField.value.trim() === "";
        }

        // --- Hàm Reset Lịch Sử ---
        function resetChat() {
            if(confirm('Bạn có chắc muốn xóa toàn bộ đoạn chat này không?')) {
                // 1. Xóa Storage
                sessionStorage.removeItem(STORAGE_KEY);
                // 2. Xóa giao diện
                messageContainer.innerHTML = '';
                // 3. Render lại câu chào
                renderMessage(DEFAULT_MSG, 'bot');
            }
        }

        // --- Hàm Toggle ---
        function toggleChat() {
            const isOpen = chatWindow.classList.contains('open');
            if (isOpen) {
                chatWindow.classList.remove('open');
                toggleBtn.classList.remove('active');
                sessionStorage.setItem(STATE_KEY, 'false');
            } else {
                chatWindow.classList.add('open');
                toggleBtn.classList.add('active');
                sessionStorage.setItem(STATE_KEY, 'true');
                setTimeout(() => inputField.focus(), 200);
            }
        }

        // --- Hàm Gửi Tin Nhắn ---
        async function sendMessage() {
            const text = inputField.value.trim();
            if (!text) return;

            renderMessage(text, 'user');
            saveMessage(text, 'user');
            inputField.value = '';
            checkInput();
            inputField.focus();

            const loadingDiv = document.createElement('div');
            loadingDiv.classList.add('message', 'bot-msg');
            loadingDiv.innerHTML = '...';
            messageContainer.appendChild(loadingDiv);
            scrollToBottom();

            try {
                const response = await fetch("{{ route('chatbot.send') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    body: JSON.stringify({ message: text })
                });
                const data = await response.json();
                if(messageContainer.contains(loadingDiv)) messageContainer.removeChild(loadingDiv);
                
                const reply = data.reply || "Xin lỗi, tôi chưa hiểu ý bạn.";
                renderMessage(reply, 'bot');
                saveMessage(reply, 'bot');
            } catch (error) {
                if(messageContainer.contains(loadingDiv)) messageContainer.removeChild(loadingDiv);
                renderMessage("Lỗi kết nối.", 'bot');
            }
        }

        // --- Gán Sự Kiện ---
        toggleBtn.addEventListener('click', toggleChat);
        minimizeBtn.addEventListener('click', toggleChat);
        resetBtn.addEventListener('click', resetChat); // Gán sự kiện Reset
        
        sendBtn.addEventListener('click', sendMessage);
        inputField.addEventListener('input', checkInput);
        inputField.addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });

        // --- Init: Load History & State ---
        const savedHistory = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '[]');
        if (savedHistory.length > 0) {
            savedHistory.forEach(msg => renderMessage(msg.text, msg.sender));
        } else {
            // Nếu chưa có lịch sử thì hiện câu chào
            renderMessage(DEFAULT_MSG, 'bot');
        }

        if (sessionStorage.getItem(STATE_KEY) === 'true') {
            chatWindow.classList.add('open');
            toggleBtn.classList.add('active');
        }
        checkInput();
    });
</script>