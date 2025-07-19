function createAlert(type = "success", message = "Thông báo", detail = "") {
    const types = {
        success: {
            bg: "bg-green-100",
            border: "border-green-400",
            text: "text-green-800",
            btn: "text-green-600 hover:text-green-800",
            label: '<i class="fas fa-check-square"></i> Thành công:',
        },
        warning: {
            bg: "bg-yellow-100",
            border: "border-yellow-400",
            text: "text-yellow-800",
            btn: "text-yellow-600 hover:text-yellow-800",
            label: '<i class="fas fa-exclamation-triangle"></i> Thông báo:',
        },
        danger: {
            bg: "bg-red-100",
            border: "border-red-400",
            text: "text-red-800",
            btn: "text-red-600 hover:text-red-800",
            label: '<i class="fas fa-times-circle"></i> Thông báo:',
        },
    };

    const config = types[type] || types.warning;

    const alert = document.createElement("div");
    alert.className = `fixed top-4 right-4 z-[9999] ${config.bg} ${config.border} ${config.text} px-6 py-4 rounded-lg shadow-lg flex flex-col gap-2 min-w-[300px]`;

    alert.innerHTML = `
        <div class="flex items-start gap-2">
            <div class="flex-1">
                <strong class="font-semibold">${config.label}</strong>
                <div>${message}</div>
            </div>
            <button class="${
                config.btn
            } font-bold text-xl leading-none close-alert">×</button>
        </div>
    `;

    document.body.appendChild(alert);

    // Auto hide
    setTimeout(() => {
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = 0;
        setTimeout(() => alert.remove(), 500);
    }, 8000);

    // Manual close
    alert.querySelector(".close-alert").addEventListener("click", () => {
        alert.remove();
    });
}

// Lắng nghe sự kiện success-alert
window.addEventListener("success-alert", (event) => {
    createAlert("success", event.detail.message || "Thành công!");
});

// Lắng nghe sự kiện warning-alert (nhiều dòng lỗi)
window.addEventListener("warning-alert", (event) => {
    let message = event.detail.message || "Có cảnh báo!";
    let messagesHtml = "";

    if (event.detail.messages) {
        const lines = Array.isArray(event.detail.messages)
            ? event.detail.messages
            : event.detail.messages.split("\n");

        messagesHtml = lines
            .map((line) => `<div class="text-sm ml-a2">- ${line}</div></br>`)
            .join("");
    }

    createAlert(
        "warning",
        `
        <div>${message}</div>
        ${messagesHtml}
    `, event.detail.errors);
});

// Lắng nghe sự kiện warning-alert (nhiều dòng lỗi)
window.addEventListener("danger-alert", (event) => {
    let message = event.detail.message || "Có cảnh báo!";
    let messagesHtml = "";

    if (event.detail.messages) {
        const lines = Array.isArray(event.detail.messages)
            ? event.detail.messages
            : event.detail.messages.split("\n");

        messagesHtml = lines
            .map((line) => `<div class="text-sm ml-2">- ${line}</div>`)
            .join("");
    }

    createAlert(
        "danger",
        `
        <div>${message}</div>
        ${messagesHtml}
    `, event.detail.errors
    );
});