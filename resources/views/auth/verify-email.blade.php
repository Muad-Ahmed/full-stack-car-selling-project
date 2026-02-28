<x-app-layout>
    <div class="container">
        <div class="card p-large my-large">
            <h2>Verify Your Email Address</h2>
            <div class="my-medium">
                Before proceeding, please check your email for a verification link.
                If you did not receive the email,
                <form action="{{ route('verification.send') }}" method="post" class="inline-flex">
                    @csrf
                    <button class="btn-link">click here to request another</button>
                </form>
            </div>
            
            {{-- skip verify step for deom user --}}
            <div class="skip-verify-container">
                <p class="skip-paragraph">Reviewing the project? You can skip this step:</p>
                <form method="POST" action="{{ route('verify.skip') }}">
                    @csrf
                    <button type="submit" class="btn-skip-verify">
                        <span>⚡</span> Skip Verification (Demo Mode)
                    </button>
                </form>
            </div>

            <div>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
