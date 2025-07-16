// Xử lý thao tác cho máy scanner: Lắng nghe phím bất kỳ ngoài input để focus lại input và chọn hết nội dung
document.addEventListener("keydown", function (e) {
    // Xử lý thao tác cho máy scanner
    const input = document.getElementById("scanInputFocus");
    if (!input) return;

    input.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            // Không preventDefault, để form Livewire vẫn xử lý submit
            // Chỉ blur để rút focus sau khi submit được kích hoạt
            setTimeout(() => input.blur(), 0);
        }
    });

    // Khi nhấn Enter trong input, blur để rút focus (không ngăn submit)
    if (document.activeElement !== input) {
        // Bỏ qua các phím điều khiển (tab, shift,...)
        if (!["Tab", "Shift", "Control", "Alt", "Meta"].includes(e.key)) {
            input.focus();
            input.select();
        }
    }
});

// Xử lý thao tác cho nút Xem của suggestions
function triggerManualScan(serialNumber) {
    const input = document.querySelector("#scanInputBox input");
    input.value = serialNumber;
    input.dispatchEvent(new Event("input")); // Cập nhật wire:model.defer
    document.getElementById("formTriggerLivewire").requestSubmit();
}

function triggerRealtimeScan(serialNumber) {
    const input = document.querySelector("#scanInputBox input");
    input.value = serialNumber;
    input.dispatchEvent(new Event("input"));
}
document.addEventListener("DOMContentLoaded", function () {
    const panel = document.querySelector(".user-panel");
    const badge = document.querySelector(".user-role-badge");

    if (!panel || !badge) return;

    const checkWidth = () => {
        if (panel.offsetWidth < 100) {
            badge.classList.add("opacity-0");
            badge.classList.remove("opacity-100");
        } else {
            badge.classList.remove("opacity-0");
            badge.classList.add("opacity-100");
        }
    };

    checkWidth();

    const observer = new ResizeObserver(checkWidth);
    observer.observe(panel);

    window.addEventListener("resize", checkWidth);
});

// Mở modal
window.addEventListener("show-popup", function () {
    document.getElementById("popup-overlay").style.display = "flex";
});

function closePopup() {
    document.getElementById("popup-overlay").style.display = "none";
}
