<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Kebutuhan

1. PHP v8
2. Composer
3. PostgreSQL

## Cara Penggunaan

1. Download file simpan di localhost
2. Buka terminal arahkan ke folder project, ketik "composer install", "composer update" di project
3. Buat database di PostgreSQL dengan nama test
4. Restore database. file berada di folder databasefile
5. Ubah file .env sesuaikan db, username, password sesuai dengan konfigurasi PostgreSQL anda
6. Buka terminal arahkan ke folder project, ketik "php artisan serve"
7. Buka terminal arahkan ke folder project, ketik "php artisan websockets:serve"
8. Akses di browser "localhost:8000"
9. Untuk API bisa diakses di browser dengan mengetik "localhost:8000/api/documentation"
10. Untuk Websocket bisa diakses di browser dengan mengetik "localhost:8000/laravel-websockets"
