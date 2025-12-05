# Recipedia

Aplikasi web manajemen resep kuliner berbasis Laravel.

## Fitur

- Registrasi dan autentikasi pengguna
- CRUD resep masakan
- Upload gambar resep
- Like/unlike resep
- Sistem komentar
- Pencarian resep
- Dashboard pengguna
- Export resep ke PDF

## Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

## Teknologi

- Laravel 11
- MySQL
- Tailwind CSS
- Alpine.js
