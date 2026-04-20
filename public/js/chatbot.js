/**
 * Chatbot Logic for KSP Harapan Mulya
 */

let isChatOpen = false;
let isTyping = false;
let chatHistory = [];
let messageCount = 0;
const MAX_MESSAGES = 30;
const COOLDOWN_TIME = 3000; // 3 detik
let lastMessageTime = 0;

function toggleChatbot() {
    const window = document.getElementById('chatbot-window');
    const trigger = document.getElementById('chatbot-trigger');
    
    isChatOpen = !isChatOpen;
    
    if (isChatOpen) {
        window.classList.remove('hidden');
        trigger.querySelector('i').classList.replace('bi-robot', 'bi-chevron-down');
        document.getElementById('chatbot-input').focus();
    } else {
        window.classList.add('hidden');
        trigger.querySelector('i').classList.replace('bi-chevron-down', 'bi-robot');
    }
}

function handleChatKeydown(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
}

function sendQuickMessage(text) {
    document.getElementById('chatbot-input').value = text;
    sendMessage();
}

async function sendMessage() {
    const input = document.getElementById('chatbot-input');
    const now = Date.now();
    const message = input.value.trim();
    
    if (!message || isTyping) return;
    
    // 1. Cek Sesi Limit (Lokal)
    if (messageCount >= MAX_MESSAGES) {
        addMessageToUI('bot', `Batas chat sesi ini (${MAX_MESSAGES} pesan) telah tercapai. Silakan muat ulang halaman jika diperlukan.`, true);
        input.value = '';
        return;
    }

    // 2. Cek Cooldown
    const timeSinceLastMessage = now - lastMessageTime;
    if (timeSinceLastMessage < COOLDOWN_TIME) {
        const remaining = Math.ceil((COOLDOWN_TIME - timeSinceLastMessage) / 1000);
        addMessageToUI('bot', `Sabar ya, tunggu ${remaining} detik lagi sebelum bertanya kembali.`, true);
        return;
    }
    
    lastMessageTime = now;
    messageCount++;
    
    // Add user message to UI
    addMessageToUI('user', message);
    input.value = '';
    
    // Add typing indicator
    showTypingIndicator();
    
    try {
        // Determine the correct URL
        let url = typeof CHATBOT_API_URL !== 'undefined' ? CHATBOT_API_URL : '/chatbot/ask';
        
        // Log debugging info
        console.log('🤖 Chatbot Debug Info:');
        console.log('URL yang digunakan:', url);
        console.log('Pesan:', message);
        console.log('Sejarah:', chatHistory);
        
        const fetchOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include', // Penting untuk mengirim session/cookie jika beda sub-origin
            body: JSON.stringify({
                message: message,
                history: chatHistory
            })
        };
        
        // Tambahkan CSRF token jika ada
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
            fetchOptions.headers['X-CSRF-TOKEN'] = csrfToken;
            console.log('CSRF Token ada:', csrfToken.substring(0, 10) + '...');
        }
        
        console.log('Mengirim request ke:', url);
        
        const response = await fetch(url, fetchOptions);
        
        console.log('Status Response:', response.status);
        console.log('Headers:', response.headers);
        
        if (response.status === 429) {
            hideTypingIndicator();
            const errData = await response.json();
            addMessageToUI('bot', errData.error || 'Batas penggunaan tercapai.', true);
            messageCount = MAX_MESSAGES; // Sinkronkan ke limit
            return;
        }

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        console.log('Data parsed:', data);
        hideTypingIndicator();
        
        if (data.error) {
            addMessageToUI('bot', data.error, true);
        } else if (data.response) {
            addMessageToUI('bot', data.response);
            // Update history (limit to last 10 messages for context efficiency)
            chatHistory.push({ role: 'user', text: message });
            chatHistory.push({ role: 'model', text: data.response });
            if (chatHistory.length > 10) chatHistory = chatHistory.slice(-10);
            
            // Beri info jika mendekati limit
            if (MAX_MESSAGES - messageCount <= 3 && MAX_MESSAGES - messageCount > 0) {
                setTimeout(() => {
                    addMessageToUI('bot', `Catatan: Anda memiliki ${MAX_MESSAGES - messageCount} sisa pertanyaan di sesi ini.`, false);
                }, 500);
            }
        } else {
            console.error('Response tidak memiliki error atau response:', data);
            addMessageToUI('bot', 'Format respons tidak dikenali dari server.', true);
        }
        
    } catch (error) {
        hideTypingIndicator();
        console.error('❌ Chatbot Error Details:', {
            message: error.message,
            stack: error.stack,
            name: error.name
        });
        
        // Pesan error yang lebih detail
        let errorMsg = 'Kesalahan koneksi: ';
        if (error.message.includes('Failed to fetch')) {
            errorMsg += 'Tidak dapat terhubung ke server (Network Error/CORS Issue)';
        } else if (error.message.includes('HTTP')) {
            errorMsg += error.message;
        } else if (error.message.includes('JSON')) {
            errorMsg += 'Server mengirim respons yang tidak valid';
        } else {
            errorMsg += error.message || 'Gagal terhubung ke host lokal atau server backend sedang mati.';
        }
        
        addMessageToUI('bot', errorMsg, true);
    }
}

function addMessageToUI(role, text, isError = false) {
    const container = document.getElementById('chatbot-messages');
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${role} animate-in ${isError ? 'error-message' : ''}`;
    
    messageDiv.innerHTML = `
        <div class="message-content">
            ${isError ? '<i class="bi bi-exclamation-triangle-fill me-2"></i>' : ''}
            ${formatMessageText(text)}
            <div class="message-time">${time}</div>
        </div>
    `;
    
    container.appendChild(messageDiv);
    container.scrollTop = container.scrollHeight;
}

function formatMessageText(text) {
    // Simple markdown-like formatting
    return text
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\n/g, '<br>');
}

function showTypingIndicator() {
    isTyping = true;
    const container = document.getElementById('chatbot-messages');
    const typingDiv = document.createElement('div');
    typingDiv.id = 'typing-indicator';
    typingDiv.className = 'message bot';
    typingDiv.innerHTML = `
        <div class="message-content typing">
            <span></span><span></span><span></span>
        </div>
    `;
    container.appendChild(typingDiv);
    container.scrollTop = container.scrollHeight;
    
    document.getElementById('chatbot-send').disabled = true;
}

function hideTypingIndicator() {
    isTyping = false;
    const indicator = document.getElementById('typing-indicator');
    if (indicator) indicator.remove();
    
    document.getElementById('chatbot-send').disabled = false;
}

// Auto-expand textarea
document.getElementById('chatbot-input').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Animation for messages
const style = document.createElement('style');
style.innerHTML = `
    .animate-in {
        animation: message-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    .message.error-message .message-content {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
        border: 1px solid #fecaca;
    }
    @keyframes message-in {
        from { opacity: 0; transform: translateY(10px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
`;
document.head.appendChild(style);
