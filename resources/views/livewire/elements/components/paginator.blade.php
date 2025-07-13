@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between space-x-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white cursor-default leading-5 rounded-md">
                « Quay lại
            </span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 leading-5 rounded-md focus:outline-none focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                « Quay lại
            </button>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden md:flex space-x-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white cursor-default leading-5">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-100 cursor-default leading-5 rounded-md">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 leading-5 rounded-md focus:outline-none focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
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
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 leading-5 rounded-md focus:outline-none focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                Kế tiếp »
            </button>
        @else
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white cursor-default leading-5 rounded-md">
                Kế tiếp »
            </span>
        @endif
    </nav>
@endif
