# Panduan Instalasi Recipedia (Versi Laragon)

Berikut adalah langkah-langkah untuk menjalankan project Recipedia di laptop masing-masing menggunakan Laragon.

## 1. Persiapan (Prerequisites)

Pastikan laptop teman-teman sudah terinstall software berikut:

1.  **Laragon** (Full Version recommended): [Download Laragon](https://laragon.org/download/)
    *   Laragon biasanya sudah menyertakan **PHP**, **MySQL**, **Composer**, dan **Node.js**.
    *   Pastikan kalian sudah klik tombol **"Start All"** di Laragon.
2.  **Visual Studio Code** (Text Editor): [Download VS Code](https://code.visualstudio.com/)

*Catatan: Jika Node.js belum ada di Laragon kalian, silakan download terpisah di [nodejs.org](https://nodejs.org/).*

---

## 2. Cara Membuka Project

1.  **Extract File Zip**:
    *   Extract folder `recipedia` ke dalam folder `www` di Laragon kalian (biasanya di `C:\laragon\www\recipedia`).
    *   *Atau bisa ditaruh di mana saja, tapi di `www` lebih rapi.*
2.  **Buka di VS Code**:
    *   Buka Visual Studio Code.
    *   Klik menu **File** -> **Open Folder**.
    *   Pilih folder `recipedia` tersebut.

---

## 3. Setup Project (Dilakukan di Terminal VS Code)

Buka Terminal di VS Code dengan cara: Klik menu **Terminal** -> **New Terminal**. Lalu ketik perintah-perintah berikut satu per satu:

### Langkah 1: Install Library
Jika folder `vendor` belum ada, jalankan:
```bash
composer install
```

Jika folder `node_modules` belum ada, jalankan:
```bash
npm install
```

### Langkah 2: Setup Environment (.env)
1.  Cari file bernama `.env.example`.
2.  Copy file tersebut dan rename menjadi `.env`.
    *   Bisa dengan cara manual (copy-paste lalu rename).
    *   Atau lewat terminal: `cp .env.example .env` (Git Bash) atau `copy .env.example .env` (CMD).
3.  Buka file `.env` yang baru dibuat. Karena pakai Laragon (MySQL default), settingan biasanya sudah pas:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=recipedia
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    *(Biarkan password kosong jika kalian tidak mengubah settingan default Laragon)*

### Langkah 3: Generate Key Aplikasi
Jalankan perintah ini di terminal:
```bash
php artisan key:generate
```

### Langkah 4: Setup Database
1.  Pastikan tombol **"Start All"** di Laragon sudah diklik (MySQL berjalan).
2.  Jalankan perintah ini untuk membuat database dan tabel secara otomatis:
    ```bash
    php artisan migrate:fresh --seed
    ```
    *(Jika muncul pertanyaan "Would you like to create it?", ketik `yes` lalu Enter)*

---

## 4. Menjalankan Website

Kalian bisa menggunakan fitur "Pretty URL" Laragon (misal: `http://recipedia.test`), tapi cara paling **stabil dan pasti berhasil** untuk semua orang adalah menggunakan perintah bawaan Laravel.

Jalankan **dua perintah** ini di **dua terminal berbeda** di VS Code:

1.  **Terminal 1 (untuk Backend PHP):**
    ```bash
    php artisan serve
    ```
    *Akan muncul tulisan: Server running on [http://127.0.0.1:8000]*

2.  **Terminal 2 (untuk Frontend/CSS):**
    *   Klik tanda `+` di pojok kanan terminal untuk membuka terminal baru.
    *   Ketik:
    ```bash
    npm run dev
    ```

3.  **Buka Browser**:
    *   Buka browser (Chrome/Edge).
    *   Ketik alamat: `http://localhost:8000`

Selesai! Website Recipedia siap digunakan.

---

## Akun Login (Default)
Jika menggunakan data dummy (seed), bisa login dengan:
*   **Email**: `test@example.com`
*   **Password**: `password`
