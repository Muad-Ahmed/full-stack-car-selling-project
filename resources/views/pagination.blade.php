<?php
/** @var $paginator \Illuminate\Pagination\LengthAwarePaginator */
/** @var $elements array */
?>

{{-- Check if there is more than one page to show pagination --}}
@if ($paginator->hasPages())
    <nav class="pagination my-large">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{-- If on the first page, show the icon without a link (disabled) --}}
            <span class="pagination-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </span>
        @else
            {{-- If not on the first page, provide the link to the previous page --}}
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
        @endif



        {{-- Loop through the pagination elements (numbers and dots) --}}
        @foreach ($elements as $element)
            {{-- Display "Three Dots" separator if it's a string --}}
            @if (is_string($element))
                <span class="pagination-item"> {{ $element }} </span>
            @endif

            {{-- Display Page Numbers --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{-- Mark the current page with an 'active' class --}}
                        <span class="pagination-item active"> {{ $page }} </span>
                    @else
                        {{-- Provide links for other pages --}}
                        <a href="{{ $url }}" class="pagination-item"> {{ $page }} </a>
                    @endif
                @endforeach
            @endif
        @endforeach



        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            {{-- If more pages exist, provide the link to the next page --}}
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        @else
            {{-- If on the last page, show the icon without a link (disabled) --}}
            <span class="pagination-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
        @endif


    </nav>
@endif
