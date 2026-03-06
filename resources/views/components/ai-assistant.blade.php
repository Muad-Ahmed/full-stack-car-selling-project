<div id="ai-assistant-widget" class="ai-assistant-widget">
    <!-- Floating Icon -->
    <button id="ai-assistant-toggle" class="ai-assistant-toggle" aria-label="Open AI Assistant">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; height: 24px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="ai-assistant-window" class="ai-assistant-window hidden">
        <div class="ai-assistant-header">
            <h3>AI Assistant</h3>
            <button id="ai-assistant-close" class="ai-assistant-close">&times;</button>
        </div>
        <div id="botui-app" class="botui-app-container">
            <bot-ui></bot-ui>
        </div>
        <div class="ai-assistant-suggestions" id="ai-suggestions">
            <button class="suggestion-btn" data-query="How to buy a car?">How to buy a car?</button>
            <button class="suggestion-btn" data-query="Can I sell my car here?">Sell my car</button>
            <button class="suggestion-btn" data-query="What's the best price?">Best price?</button>
        </div>
    </div>
</div>


@push('js')
@vite(['resources/css/app.css','resources/js/ai-assistant.js'])
@endpush
