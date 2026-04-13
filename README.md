# Karta Mulia Website

Panduan setup cepat project Laravel + Filament.

## 1) Install dependency

```bash
composer install
npm install
```

## 2) Siapkan file environment

Copy file `.env`:

```bash
cp .env.example .env
```

Lalu isi konfigurasi penting berikut di `.env`:

```env
APP_NAME="Karta Mulia"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kartamulia
DB_USERNAME=root
DB_PASSWORD=
```

Generate app key:

```bash
php artisan key:generate
```

## 3) Migrasi dan seed database

Jalankan migrasi:

```bash
php artisan migrate
```

Jalankan seeder:

```bash
php artisan db:seed
```

Catatan:
- Seeder utama sekarang tidak lagi membuat user test default.
- Seeder yang dijalankan saat ini: `IdentitySeeder`.

## 4) Buat user Filament pertama

```bash
php artisan make:filament-user
```

Ikuti prompt untuk mengisi nama, email, dan password admin pertama.

## 5) Jalankan aplikasi

```bash
php artisan serve
```

Panel admin Filament biasanya dapat diakses di:

`/admin`
