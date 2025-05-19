import "./bootstrap";
import "flowbite";

// Function untuk menampilkan toast
document.addEventListener("DOMContentLoaded", () => {
    // Durasi toast tampil (ms)
    const toastDuration = 5000;

    document.querySelectorAll('[role="alert"]').forEach((toast) => {
        // Auto-close setelah toastDuration
        setTimeout(() => {
            toast.classList.add("opacity-0");
            setTimeout(() => toast.remove(), 300); // animate + remove
        }, toastDuration);

        // Manual close
        toast.querySelectorAll("[data-dismiss-target]").forEach((btn) => {
            btn.addEventListener("click", () => {
                toast.classList.add("opacity-0");
                setTimeout(() => toast.remove(), 300);
            });
        });
    });
});
