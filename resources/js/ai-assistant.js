// AI Assistant JS
// Using the global BotUI instance provided by the CDN in ai-assistant.blade.php

(function () {
    console.log('AI Assistant script initialized');

    function initAssistant() {
        const toggleBtn = document.getElementById('ai-assistant-toggle');
        const closeBtn = document.getElementById('ai-assistant-close');
        const chatWindow = document.getElementById('ai-assistant-window');
        const suggestions = document.querySelectorAll('.suggestion-btn');

        if (!toggleBtn || !chatWindow) {
            console.error('AI Assistant elements not found');
            return;
        }

        let botui = null;
        let isInitialized = false;

        // Toggle Chat Window
        toggleBtn.addEventListener('click', (e) => {
            console.log('Toggle clicked');
            e.preventDefault();
            chatWindow.classList.toggle('hidden');
            if (!chatWindow.classList.contains('hidden') && !isInitialized) {
                initBotUI();
            }
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                chatWindow.classList.add('hidden');
            });
        }

        // Initialize BotUI
        function initBotUI() {
            console.log('Initializing BotUI...');
            try {
                botui = new BotUI('botui-app');
                isInitialized = true;

                botui.message.add({
                    content: 'Hello 👋 I can help you navigate this website. What would you like to do?'
                }).then(() => {
                    return askUser();
                });
            } catch (err) {
                console.error('Error initializing BotUI:', err);
            }
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
                console.log('Suggestion clicked:', query);

                if (!isInitialized) {
                    chatWindow.classList.remove('hidden');
                    initBotUI();
                }

                // Hide the suggestions container
                const suggestionsContainer = document.getElementById('ai-suggestions');
                if (suggestionsContainer) {
                    suggestionsContainer.style.display = 'none';
                }

                botui.message.add({
                    human: true,
                    content: query
                });

                sendToBackend(query);
            });
        });
    }

    // Run init on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAssistant);
    } else {
        initAssistant();
    }
})();
