@if ($paginator->hasPages())
    <nav class="flex items-center gap-2 justify-center mt-4">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-200 cursor-not-allowed">Trước</span>
        @else
            <button wire:click="previousPage" class="px-3 py-1 text-gray-600">
                Trước
            </button>
        @endif

        {{-- Page Numbers --}}
        <div class="hidden md:flex gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 font-bold">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 text-gray-600">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" class="px-3 py-1 text-gray-600">
                Sau
            </button>
        @else
            <span class="px-3 py-1 text-gray-200 cursor-not-allowed">Sau</span>
        @endif
    </nav>
@endif
