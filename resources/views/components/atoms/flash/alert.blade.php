<!-- Alert container -->
<div id="alert-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<script>
function createAlert(data, type = 'danger') {
    const container = document.getElementById('alert-container');
    if (!container) return;

    // Màu subtle
    const colors = {
        danger: 'bg-red-100 text-red-800',
        success: 'bg-green-100 text-green-800',
        info: 'bg-blue-100 text-blue-800',
        warning: 'bg-yellow-100 text-yellow-800'
    };

    const alert = document.createElement('div');
    alert.className = `
        ${colors[type] || colors.danger} p-4 rounded shadow flex justify-between items-start gap-4 max-w-md
        transform transition-all duration-500 ease-out opacity-0 translate-y-4
    `;

    const content = document.createElement('div');
    content.innerHTML = `<strong>${data.message || ''}</strong>${
        data.errors ? '<br>' + Object.values(data.errors).flat().join('<br>') : ''
    }`;

    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    closeBtn.className = 'ml-4 font-bold text-lg';
    closeBtn.addEventListener('click', () => {
        alert.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => alert.remove(), 500);
    });

    alert.appendChild(content);
    alert.appendChild(closeBtn);
    container.appendChild(alert);

    // Fade-down xuất hiện mượt
    setTimeout(() => {
        alert.classList.remove('opacity-0', 'translate-y-4');
    }, 10);

    // Tự động ẩn sau 5s
    setTimeout(() => {
        alert.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => alert.remove(), 500);
    }, 5000);
}

// Lắng nghe sự kiện Livewire
['danger-alert', 'success-alert', 'info-alert', 'warning-alert'].forEach(eventName => {
    document.addEventListener(eventName, event => {
        const type = eventName.split('-')[0];
        createAlert(event.detail, type);
    });
});
</script>
