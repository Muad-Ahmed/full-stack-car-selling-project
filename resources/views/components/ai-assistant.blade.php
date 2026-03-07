<div id="ai-assistant-widget" class="ai-assistant-widget">
    <!-- Floating Icon -->
    <button id="ai-assistant-toggle" class="ai-assistant-toggle" aria-label="Open AI Assistant">
        <!-- Robot Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="10" rx="2" />
            <circle cx="12" cy="5" r="2" />
            <path d="M12 7v4" />
            <line x1="8" y1="16" x2="8" y2="16" />
            <line x1="16" y1="16" x2="16" y2="16" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="ai-assistant-window" class="ai-assistant-window hidden">
        <div class="ai-assistant-header">
            <h3>🤖  AI Assistant</h3>
            <button id="ai-assistant-close" class="ai-assistant-close">&times;</button>
        </div>
        <div id="botui-app" class="botui-app-container">
            <bot-ui></bot-ui>
        </div>
        <div class="ai-assistant-suggestions" id="ai-suggestions">
            <button class="suggestion-btn" data-query="How can I buy a car on this website?">🔑 How to buy a car?</button>
            <button class="suggestion-btn" data-query="How do I list my car for sale?">🚗 Sell my car</button>
            <button class="suggestion-btn" data-query="Where can I search for cars?">🔍 Find cars</button>
        </div>
    </div>
</div>


@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/botui/build/botui.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/botui/build/botui-theme-default.css" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/botui/build/botui.js"></script>
@vite(['resources/js/ai-assistant.js'])
@endpush
