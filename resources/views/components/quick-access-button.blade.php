@props([
    'email' => 'admin@example.com',
    'password' => 'password',
    'label' => 'Login as Admin',
])

<div class="quick-access-wrapper">
    <button type="submit" formaction="{{ route('login.demo') }}" formnovalidate {{ $attributes->merge(['class' => 'btn-quick-access']) }}>
        <span class="icon-key">🔑</span>{{ $label }}
    </button>
    <p class="quick-access-note">
        <span class="dot"></span> Quick demo access for demonstration purposes only
    </p>
</div>
