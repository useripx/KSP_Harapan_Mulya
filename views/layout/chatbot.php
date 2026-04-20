<script>
    // Gunakan path relatif untuk menghindari isu CORS jika host berbeda (localhost vs 127.0.0.1)
    const CHATBOT_API_URL = '<?= parse_url(url("/chatbot/ask"), PHP_URL_PATH) ?>';
    console.log('📍 Chatbot initialized with Path:', CHATBOT_API_URL);
    console.log('📍 Current hostname:', window.location.hostname);
    console.log('📍 Current pathname:', window.location.pathname);
</script>

<!-- Chatbot Trigger Button -->
<div id="chatbot-trigger" class="chatbot-trigger" onclick="toggleChatbot()">
    <div class="chatbot-pulse"></div>
    <i class="bi bi-robot"></i>
    <span class="chatbot-tooltip">Tanya Anna</span>
</div>

<!-- Chatbot Window -->
<div id="chatbot-window" class="chatbot-window hidden">
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-avatar">
                <i class="bi bi-robot"></i>
                <div class="online-indicator"></div>
            </div>
            <div>
                <h6 class="mb-0">Anna </h6>
                <span class="status-text">Online | Siap Membantu</span>
            </div>
        </div>
        <button class="btn-close-chat" onclick="toggleChatbot()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div id="chatbot-messages" class="chatbot-messages">
        <!-- Welcome Message -->
        <div class="message bot">
            <div class="message-content">
                Halo! Saya Anna Asisten KSP Harapan Mulya. Ada yang bisa saya bantu hari ini?
                <div class="message-time"><?= date('H:i') ?></div>
            </div>
        </div>
    </div>

    <!-- Suggested Questions -->
    <div class="chatbot-suggestions">
        <button onclick="sendQuickMessage('Syarat daftar?')">Syarat daftar?</button>
        <button onclick="sendQuickMessage('Lupa password?')">Lupa password?</button>
        <button onclick="sendQuickMessage('Lupa username?')">Lupa username?</button>
    </div>

    <div class="chatbot-input-area">
        <textarea id="chatbot-input" placeholder="Ketik pesan..." rows="1"
            onkeydown="handleChatKeydown(event)"></textarea>
        <button id="chatbot-send" onclick="sendMessage()">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>
</div>

<style>
    /* Chatbot Trigger */
    .chatbot-trigger {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
        z-index: 9999;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .chatbot-trigger:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.5);
    }

    .chatbot-trigger:active {
        transform: scale(0.95);
    }

    .chatbot-pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.4);
        animation: pulse-ring 2s infinite;
        z-index: -1;
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(1);
            opacity: 0.6;
        }

        100% {
            transform: scale(1.6);
            opacity: 0;
        }
    }

    .chatbot-tooltip {
        position: absolute;
        right: 75px;
        background: var(--card);
        color: var(--foreground);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transition: 0.3s;
        border: 1px solid var(--border);
    }

    .chatbot-trigger:hover .chatbot-tooltip {
        opacity: 1;
        visibility: visible;
    }

    /* Chatbot Window */
    .chatbot-window {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 380px;
        height: 550px;
        background: var(--card);
        border-radius: 20px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid var(--border);
        transform-origin: bottom right;
    }

    .chatbot-window.hidden {
        opacity: 0;
        visibility: hidden;
        transform: scale(0.8) translateY(20px);
    }

    .chatbot-header {
        padding: 20px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chatbot-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chatbot-avatar {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        position: relative;
        backdrop-filter: blur(4px);
    }

    .online-indicator {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        background: #10b981;
        border: 2px solid #2563eb;
        border-radius: 50%;
    }

    .status-text {
        font-size: 11px;
        opacity: 0.8;
    }

    .btn-close-chat {
        background: transparent;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        opacity: 0.8;
        transition: 0.2s;
    }

    .btn-close-chat:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Messages Area */
    .chatbot-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: var(--background);
        display: flex;
        flex-direction: column;
        gap: 15px;
        scroll-behavior: smooth;
    }

    .message {
        max-width: 85%;
        display: flex;
        flex-direction: column;
    }

    .message.user {
        align-self: flex-end;
    }

    .message.bot {
        align-self: flex-start;
    }

    .message-content {
        padding: 12px 16px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.5;
        position: relative;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
    }

    .user .message-content {
        background: #2563eb;
        color: white;
        border-bottom-right-radius: 2px;
    }

    .bot .message-content {
        background: var(--card);
        color: var(--foreground);
        border: 1px solid var(--border);
        border-bottom-left-radius: 2px;
    }

    .message-time {
        font-size: 10px;
        opacity: 0.6;
        margin-top: 4px;
        text-align: right;
    }

    /* Typing Indicator */
    .typing {
        display: flex;
        gap: 4px;
        padding: 8px 12px;
    }

    .typing span {
        width: 6px;
        height: 6px;
        background: var(--muted-foreground);
        border-radius: 50%;
        animation: typing-dots 1.4s infinite ease-in-out;
    }

    .typing span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing-dots {

        0%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-5px);
        }
    }

    /* Suggestions */
    .chatbot-suggestions {
        padding: 10px 20px;
        display: flex;
        gap: 8px;
        overflow-x: auto;
        background: var(--background);
        scrollbar-width: none;
        /* Firefox */
    }

    .chatbot-suggestions::-webkit-scrollbar {
        display: none;
        /* Chrome/Safari */
    }

    .chatbot-suggestions button {
        background: var(--card);
        border: 1px solid var(--border);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: var(--primary);
        white-space: nowrap;
        cursor: pointer;
        transition: 0.2s;
        font-weight: 500;
    }

    .chatbot-suggestions button:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Input Area */
    .chatbot-input-area {
        padding: 15px 20px;
        background: var(--card);
        border-top: 1px solid var(--border);
        display: flex;
        align-items: flex-end;
        gap: 12px;
    }

    .chatbot-input-area textarea {
        flex: 1;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 14px;
        max-height: 100px;
        resize: none;
        background: var(--background);
        color: var(--foreground);
        transition: 0.2s;
    }

    .chatbot-input-area textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    #chatbot-send {
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: 0.2s;
    }

    #chatbot-send:hover {
        background: #1d4ed8;
        transform: scale(1.05);
    }

    #chatbot-send:disabled {
        background: var(--muted);
        color: var(--muted-foreground);
        cursor: not-allowed;
        transform: none;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .chatbot-window {
            width: calc(100% - 40px);
            right: 20px;
            bottom: 90px;
            height: calc(100vh - 120px);
        }
    }
</style>