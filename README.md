# SIAMI Polines

Sistem Informasi Audit Mutu Internal (SIAMI) Polines adalah aplikasi berbasis web yang dikembangkan untuk mendukung proses audit mutu internal di Politeknik Negeri Semarang (Polines).

## Prasyarat

-   **PHP** (&gt;= 8.2)
-   **Composer** (untuk mengelola dependensi PHP)
-   **Node.js** dan **NPM** (untuk mengelola dependensi frontend seperti Tailwind CSS)
-   **MySQL** 8.0
-   **Git** (untuk mengklon repositori)

## Instalasi di Lokal

1. **Klon Repositori**

    ```bash
    https://github.com/PBL-TI2B/siami-polines.git
    cd siami-polines
    ```

2. **Instal Dependensi PHP**

    ```bash
    composer install
    ```

3. **Instal Dependensi Frontend**

    ```bash
    npm install
    npm run build
    ```

4. Copy file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Edit file `.env` untuk mengatur koneksi database, misal:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=siami_polines
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Jalankan Migrasi dan Seeder**

    ```bash
    php artisan migrate --seed
    ```

7. **Jalankan Aplikasi**

    ```bash
    composer run dev
    ```

    Aplikasi akan tersedia di `http://localhost:8000`.

## Cara Penggunaan Komponen

### Komponen `x-breadcrumb`

Komponen ini digunakan untuk menampilkan breadcrumb navigasi di halaman.

#### Contoh Penggunaan

Di dalam file Blade (misalnya `unit-kerja/index.blade.php`):

```blade
<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => route('dashboard.index')],
    ['label' => 'Data Unit', 'url' => route('unit-kerja')]
]" />
```

#### Parameter

-   `items`: Array asosiatif yang berisi label dan URL untuk setiap item breadcrumb.
    -   `label`: Teks yang ditampilkan (contoh: "Data Unit").
    -   `url`: URL tujuan (gunakan helper `route()` untuk route Laravel).
