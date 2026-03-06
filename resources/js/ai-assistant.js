import BotUI from 'botui';

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('ai-assistant-toggle');
    const closeBtn = document.getElementById('ai-assistant-close');
    const chatWindow = document.getElementById('ai-assistant-window');
    const suggestions = document.querySelectorAll('.suggestion-btn');
    
    let botui = null;
    let isInitialized = false;

    // Toggle Chat Window
    toggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden') && !isInitialized) {
            initBotUI();
        }
    });

    closeBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
    });

    // Initialize BotUI
    function initBotUI() {
        botui = new BotUI('botui-app');
        isInitialized = true;

        botui.message.add({
            content: 'Hello! How can I help you today?'
        }).then(() => {
            return askUser();
        });
    }

    // Main Chat Loop
    function askUser() {
        botui.action.text({
            action: {
                placeholder: 'Type your message...'
            }
        }).then((res) => {
            sendToBackend(res.value);
        });
    }

    // Send Message to Laravel Backend
    async function sendToBackend(message) {
        // Show loading state
        botui.message.add({
            loading: true
        }).then((index) => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: message,
                    url: window.location.href
                })
            })
            .then(response => response.json())
            .then(data => {
                botui.message.update(index, {
                    loading: false,
                    content: data.message
                });
            })
            .catch(error => {
                console.error('Error:', error);
                botui.message.update(index, {
                    loading: false,
                    content: 'Sorry, something went wrong. Please try again later.'
                });
            })
            .finally(() => {
                askUser();
            });
        });
    }

    // Handle Suggestions
    suggestions.forEach(btn => {
        btn.addEventListener('click', () => {
            const query = btn.getAttribute('data-query');
            if (!isInitialized) {
                chatWindow.classList.remove('hidden');
                initBotUI();
            }
            
            // Add user message to UI manually since we bypass botui.action.text
            botui.message.add({
                human: true,
                content: query
            });

            sendToBackend(query);
        });
    });
});
