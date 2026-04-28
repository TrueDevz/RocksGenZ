<?php
// includes/chat.php
?>
<style>
    /* Chat Widget Styles */
    .chat-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        font-family: inherit;
    }

    .chat-button {
        background-color: var(--primary-color, #c8a97e);
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .chat-button:hover {
        transform: scale(1.05);
    }

    .chat-window {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        max-height: 500px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        display: none;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid var(--border-color, #eee);
    }

    .chat-window.open {
        display: flex;
        animation: chat-fade-in 0.3s ease;
    }

    @keyframes chat-fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .chat-header {
        background-color: var(--primary-color, #c8a97e);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h3 {
        margin: 0;
        font-size: 16px;
    }

    .chat-close {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    .chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
        gap: 10px;
        min-height: 200px;
        max-height: 300px;
    }

    .message {
        max-width: 85%;
        padding: 10px 15px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.4;
    }

    .message.bot {
        background-color: #e9ecef;
        color: #333;
        align-self: flex-start;
        border-bottom-left-radius: 5px;
    }

    .message.user {
        background-color: var(--primary-color, #c8a97e);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 5px;
    }

    .chat-options {
        padding: 15px;
        background: white;
        border-top: 1px solid var(--border-color, #eee);
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .chat-option-btn {
        background: white;
        border: 1px solid var(--primary-color, #c8a97e);
        color: var(--primary-color, #c8a97e);
        padding: 8px 12px;
        border-radius: 20px;
        cursor: pointer;
        text-align: left;
        font-size: 13px;
        transition: all 0.2s;
    }

    .chat-option-btn:hover {
        background: var(--primary-color, #c8a97e);
        color: white;
    }

    /* Mobile responsiveness */
    @media (max-width: 480px) {
        .chat-window {
            width: calc(100vw - 40px);
            right: 0;
        }
    }
</style>

<div class="chat-widget">
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <h3>Support Chat</h3>
            <button class="chat-close" onclick="toggleChat()">×</button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                Hi there! 👋 How can we help you today? Please choose a question below.
            </div>
        </div>
        <div class="chat-options" id="chatOptions">
            <button class="chat-option-btn" onclick="sendQuestion(1, 'What products do you offer?')">What products do you offer?</button>
            <button class="chat-option-btn" onclick="sendQuestion(2, 'Where are you located?')">Where are you located?</button>
            <button class="chat-option-btn" onclick="sendQuestion(3, 'Do you handle bulk orders?')">Do you handle bulk orders?</button>
            <button class="chat-option-btn" onclick="sendQuestion(4, 'How can I get a quote?')">How can I get a quote?</button>
        </div>
    </div>
    <button class="chat-button" onclick="toggleChat()" title="Chat with us">
        💬
    </button>
</div>

<script>
    function toggleChat() {
        const window = document.getElementById('chatWindow');
        window.classList.toggle('open');
    }

    function sendQuestion(id, text) {
        const messages = document.getElementById('chatMessages');
        
        // Add user message
        const userMsg = document.createElement('div');
        userMsg.className = 'message user';
        userMsg.textContent = text;
        messages.appendChild(userMsg);
        
        // Hide options temporarily
        document.getElementById('chatOptions').style.display = 'none';

        // Auto-scroll to bottom
        messages.scrollTop = messages.scrollHeight;

        // Simulate typing delay
        setTimeout(() => {
            const botMsg = document.createElement('div');
            botMsg.className = 'message bot';
            
            // Define answers
            const answers = {
                1: "We offer premium Indian rough granite blocks, marble, quartz, and other natural stones for global export.",
                2: "We source our stones from India's finest quarries and operate a global export network.",
                3: "Yes, we specialize in bulk and large-scale project supply. We can handle orders of any size.",
                4: "You can request a quote by visiting our 'Contact Us' page or emailing us directly. We typically respond within 24 hours."
            };
            
            botMsg.textContent = answers[id] || "Sorry, I couldn't find an answer to that.";
            messages.appendChild(botMsg);
            
            // Re-show options
            document.getElementById('chatOptions').style.display = 'flex';
            
            // Auto-scroll to bottom
            messages.scrollTop = messages.scrollHeight;
        }, 600);
    }
</script>
