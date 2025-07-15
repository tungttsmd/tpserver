    <header class="sticky top-0 z-50 w-full bg-main text-white shadow-md flex items-center justify-between px-4 py-2">
        {{-- Trái: menu + tiêu đề --}}
        <div class="flex items-center gap-4">
            @include('layouts.elements.headernav-push-menu')

            <h1 class="text-lg font-semibold whitespace-nowrap">
                @if (!empty($icon))
                    <i class="{{ $icon ?? 'fas fa-question' }} mr-2"></i>
                @endif
                {{ $title ?? 'Không có tiêu đề' }}
            </h1>
        </div>

        {{-- Phải: nút scan + logout --}}
        <div class="flex items-center gap-3">
            @include('layouts.elements.headernav-scan')
            <livewire:component-controller component="button-logout" />
        </div>
    </header>
