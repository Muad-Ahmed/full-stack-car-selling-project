@props(['title' => '', 'bodyClass' => null, 'footerLinks' => ''])

<x-base-layout :$title>
    <x-layouts.header />

    {{-- ==================== Toast ==================== --}}
    @session('success')
        <div class="toast-wrapper">
            <div class="toast success-message">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endsession

    @session('warning')
        <div class="toast-wrapper">
            <div class="toast warning-message">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endsession
    {{-- ==================== End Toast ==================== --}}

    {{-- ==================== Delete Modal ==================== --}}
    <div id="deleteModal" class="confirm-modal hidden">
        <div class="confirm-box">
            <h3>Confirm Delete</h3>
            <p>This action cannot be undone.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="confirm-actions">
                    <button type="button" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    {{-- ====================End Delete Modal ==================== --}}



    {{ $slot }}

</x-base-layout>
