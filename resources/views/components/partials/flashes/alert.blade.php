<!-- Alert container -->
<div id="alert-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<script>
    document.addEventListener('danger-alert', event => {
        const data = event.detail; // dữ liệu dispatch từ Livewire
        const container = document.getElementById('alert-container');
        if (!container) return;

        // Tạo alert
        const alert = document.createElement('div');
        alert.className =
            "bg-red-500 text-white p-4 rounded shadow flex justify-between items-start gap-4 max-w-md";

        // Nội dung
        const content = document.createElement('div');
        content.innerHTML =
            `<strong>${data.message}</strong><br>${Object.values(data.errors).flat().join('<br>')}`;

        // Nút đóng
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.className = "ml-4 font-bold text-lg";
        closeBtn.addEventListener('click', () => alert.remove());

        alert.appendChild(content);
        alert.appendChild(closeBtn);
        container.appendChild(alert);

        // Tự động 5s ẩn
        setTimeout(() => alert.remove(), 5000);
    });
</script>
