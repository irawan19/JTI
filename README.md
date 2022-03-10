## Cara Penggunaan

1. Download file simpan di localhost
2. Buka terminal arahkan ke folder project, ketik "composer install", "composer update" di project
3. Buat database di PostgreSQL dengan nama test
4. Restore database. file berada di folder databasefile
5. Ubah file .env sesuaikan db, username, password sesuai dengan konfigurasi PostgreSQL anda
6. Buka terminal arahkan ke folder project, ketik "php artisan serve"
7. Akses di browser "localhost:8000"
8. Untuk API bisa diakses di browser dengan mengetik "localhost:8000/api/documentation"