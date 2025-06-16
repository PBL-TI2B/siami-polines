import "./bootstrap";
import "flowbite";

/// Progress Bar Manager
const ProgressBarManager = {
    progress: 0,
    interval: null,

    // Memulai progress bar
    startProgress() {
        const container = document.getElementById("progress-bar-container");
        const bar = document.getElementById("progress-bar");
        if (!container || !bar) {
            console.error("Progress bar tidak ditemukan.");
            return;
        }

        // Reset dan tampilkan progress bar
        this.progress = 0;
        bar.style.width = "0%";
        bar.style.opacity = "1";
        container.classList.remove("hidden");

        // Simulasi progres dengan interval
        this.interval = setInterval(() => {
            this.updateProgress(this.progress + 5);
        }, 150); // Tambah 5% setiap 150ms
    },

    // Memperbarui lebar dan opacity progress bar
    updateProgress(percent) {
        const bar = document.getElementById("progress-bar");
        if (!bar) return;

        this.progress = Math.min(percent, 90); // Maksimum 90% sampai selesai
        bar.style.width = `${this.progress}%`;
        bar.style.opacity = "1";

        // Hentikan interval jika mencapai 90%
        if (this.progress >= 90) {
            clearInterval(this.interval);
        }
    },

    // Menyelesaikan progress bar
    completeProgress() {
        const container = document.getElementById("progress-bar-container");
        const bar = document.getElementById("progress-bar");
        if (!container || !bar) return;

        // Set ke 100% dan penuh opacity
        this.progress = 100;
        bar.style.width = "100%";
        bar.style.opacity = "1";
        clearInterval(this.interval);

        // Sembunyikan setelah animasi selesai
        setTimeout(() => {
            container.classList.add("hidden");
            this.progress = 0;
            bar.style.width = "0%";
            bar.style.opacity = "1";
        }, 500); // Tunggu 500ms untuk animasi
    },

    // Menghentikan progress bar (untuk error)
    stopProgress() {
        const container = document.getElementById("progress-bar-container");
        const bar = document.getElementById("progress-bar");
        if (!container || !bar) return;

        clearInterval(this.interval);
        container.classList.add("hidden");
        this.progress = 0;
        bar.style.width = "0%";
        bar.style.opacity = "0";
    },
};

// Expose ProgressBarManager secara global
window.ProgressBarManager = ProgressBarManager;

// Mulai progress bar saat halaman dimuat
document.addEventListener("DOMContentLoaded", () => {
    ProgressBarManager.startProgress();
});

// Selesaikan progress bar setelah halaman selesai dimuat
window.addEventListener("load", () => {
    ProgressBarManager.completeProgress();
});

// (Opsional) Tampilkan progress bar saat navigasi
document.addEventListener("click", (event) => {
    const link = event.target.closest("a");
    if (
        link &&
        link.href &&
        !link.target &&
        link.href.includes(window.location.origin) &&
        link.href !== "#" && // Pastikan href bukan hanya "#"
        !link.href.endsWith("#") // Pastikan href tidak diakhiri dengan "#"
    ) {
        event.preventDefault();
        ProgressBarManager.startProgress();
        setTimeout(() => {
            window.location.href = link.href;
        }, 1000); // Delay 1 detik untuk demo
    }
});

// // Loading Manager
// const LoadingManager = {
//     // Menampilkan loader halaman penuh
//     showPageLoading() {
//         const pageLoader = document.getElementById("page-loading");
//         if (pageLoader) {
//             pageLoader.classList.remove("hidden");
//         } else {
//             console.error("Page loader tidak ditemukan.");
//         }
//     },

//     // Menyembunyikan loader halaman penuh
//     hidePageLoading() {
//         const pageLoader = document.getElementById("page-loading");
//         if (pageLoader) {
//             pageLoader.classList.add("hidden");
//         } else {
//             console.error("Page loader tidak ditemukan.");
//         }
//     },

//     // Menampilkan loader komponen berdasarkan ID
//     showComponentLoading(componentId) {
//         const spinner = document.getElementById(`${componentId}-spinner`);
//         const content = document.getElementById(`${componentId}-content`);
//         if (spinner && content) {
//             spinner.classList.remove("hidden");
//             content.classList.add("opacity-50", "pointer-events-none");
//         } else {
//             console.error(
//                 `Komponen dengan ID ${componentId} tidak ditemukan atau tidak memiliki spinner/konten.`
//             );
//         }
//     },

//     // Menyembunyikan loader komponen berdasarkan ID
//     hideComponentLoading(componentId) {
//         const spinner = document.getElementById(`${componentId}-spinner`);
//         const content = document.getElementById(`${componentId}-content`);
//         if (spinner && content) {
//             spinner.classList.add("hidden");
//             content.classList.remove("opacity-50", "pointer-events-none");
//         } else {
//             console.error(
//                 `Komponen dengan ID ${componentId} tidak ditemukan atau tidak memiliki spinner/konten.`
//             );
//         }
//     },

//     // Mengatur status loader komponen (true untuk tampil, false untuk sembunyi)
//     toggleComponentLoading(componentId, state) {
//         if (state) {
//             this.showComponentLoading(componentId);
//         } else {
//             this.hideComponentLoading(componentId);
//         }
//     },
// };

// // Expose LoadingManager secara global
// window.LoadingManager = LoadingManager;

// // Sembunyikan page loader setelah halaman selesai dimuat
// document.addEventListener("DOMContentLoaded", () => {
//     LoadingManager.hidePageLoading();
// });

// // (Opsional) Tampilkan page loader saat navigasi
// document.addEventListener("click", (event) => {
//     const link = event.target.closest("a");
//     if (
//         link &&
//         link.href &&
//         !link.target &&
//         link.href.includes(window.location.origin)
//     ) {
//         event.preventDefault();
//         LoadingManager.showPageLoading();
//         setTimeout(() => {
//             window.location.href = link.href;
//         }, 500); // Delay untuk demo
//     }
// });

// Function untuk menampilkan toast
document.addEventListener("DOMContentLoaded", () => {
    // Durasi toast tampil (ms)
    const toastDuration = 5000;

    document.querySelectorAll('[role="alert"]').forEach((toast) => {
        // Tambahkan animasi masuk
        toast.classList.add("animate-fade-in");

        // Auto-close setelah toastDuration
        setTimeout(() => {
            toast.classList.remove("animate-fade-in");
            toast.classList.add("animate-fade-out");
            setTimeout(() => toast.remove(), 400); // waktu sesuai animasi keluar
        }, toastDuration);

        // Manual close
        toast.querySelectorAll("[data-dismiss-target]").forEach((btn) => {
            btn.addEventListener("click", () => {
                toast.classList.remove("animate-fade-in");
                toast.classList.add("animate-fade-out");
                setTimeout(() => toast.remove(), 400);
            });
        });
    });
});
