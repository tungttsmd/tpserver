@if (session('success') || session('error'))
    <div id="flash-message"
        class="fixed top-4 right-4 z-50 bg-white border-l-4 shadow-lg rounded px-4 py-3 flex items-start gap-3
        {{ session('success') ? 'border-green-500' : 'border-red-500' }}">

        <div class="flex-1">
            <p class="font-semibold">
                {{ session('success') ? 'Thành công' : 'Lỗi' }}
            </p>
            <p>{{ session('success') ?? session('error') }}</p>
        </div>

        <button onclick="hideFlashMessage()" class="text-gray-500 hover:text-gray-800">
            &times;
        </button>
    </div>
@endif
<script>
    window.hideFlashMessage = function() {
        const el = document.getElementById('flash-message');
        if (el) {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300); // Xóa hẳn khỏi DOM
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        const el = document.getElementById('flash-message');
        if (el) {
            // Animation xuất hiện
            el.style.transition = 'opacity 0.3s ease';
            el.style.opacity = '1';

            // Tự ẩn sau 3 giây
            setTimeout(() => hideFlashMessage(), 3000);
        }
    });
</script>
