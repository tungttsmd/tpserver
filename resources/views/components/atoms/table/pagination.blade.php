@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="fi-pagination flex items-center justify-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="fi-pagination-item text-gray-400 bg-white px-3 py-2 text-sm rounded-md cursor-not-allowed">
                Trước </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled"
                        class="fi-pagination-item text-gray-700 bg-white hover:bg-gray-100 px-3 py-2 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        Trước </button>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden md:flex gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="fi-pagination-item text-gray-500 bg-white px-3 py-2 text-sm rounded-md">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                class="fi-pagination-item font-semibold text-primary-600 bg-primary-100 px-3 py-2 text-sm rounded-md">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                class="fi-pagination-item text-gray-700 bg-white hover:bg-gray-100 px-3 py-2 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled"
                class="fi-pagination-item text-gray-700 bg-white hover:bg-gray-100 px-3 py-2 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                Sau
            </button>
        @else
            <span class="fi-pagination-item text-gray-400 bg-white px-3 py-2 text-sm rounded-md cursor-not-allowed">
                Sau
            </span>
        @endif
    </nav>
@endif
