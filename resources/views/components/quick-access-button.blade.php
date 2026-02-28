@props([
    'email' => 'admin@example.com',
    'password' => 'password',
    'label' => 'Login as Admin',
])

<div class="quick-access-wrapper">
    <form action="{{ route('login.demo') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <button type="submit" {{ $attributes->merge(['class' => 'btn-quick-access']) }}>
            <span class="icon-key">🔑</span>{{ $label }}
        </button>
    </form>
    <p class="quick-access-note">
        <span class="dot"></span> Quick demo access for demonstration purposes only
    </p>
</div>
