<style>
  [x-cloak] { display: none !important; }
</style>

<div class="flex items-center justify-between w-full px-1 pb-3 border-b">
  <div class="flex-1 min-w-0">
    <p class="text-sm font-medium text-gray-900 truncate">
      {{ Auth::user()->alias }}
    </p>
    <p class="text-xs text-gray-500 truncate">
      {{ Auth::user()->roles->first()->display_name ?? 'N/A' }}
    </p>
  </div>

  <div x-data="{ open: false }" class="relative">
    <button 
      @click="open = !open" 
      class="p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
      :class="{ 'bg-gray-100': open }"
    >
      <i class="w-5 h-5 fas fa-ellipsis-h"></i>
    </button>

    <!-- Thêm x-cloak vào đây -->
    <div 
      x-show="open" 
      x-cloak
      @click.away="open = false"
      x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="transform opacity-0 scale-95"
      x-transition:enter-end="transform opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75"
      x-transition:leave-start="transform opacity-100 scale-100"
      x-transition:leave-end="transform opacity-0 scale-95"
      class="absolute right-0 z-10 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    >
      <div class="py-1">
        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
          <i class="w-5 mr-2 fas fa-user-cog"></i>
          <span>Hồ sơ</span>
        </a>
        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
          <i class="w-5 mr-2 fas fa-key"></i>
          <span>Đổi mật khẩu</span>
        </a>
        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
          <i class="w-5 mr-2 fas fa-cog"></i>
          <span>Cài đặt</span>
        </a>
        <div class="border-t border-gray-100 my-1"></div>
        <form method="POST" action="{{ route('auth.logout') }}">
          @csrf
          <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-gray-100">
            <i class="w-5 mr-2 fas fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

