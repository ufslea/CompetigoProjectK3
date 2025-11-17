Instalasi & Setup

1. Clone repo  
git clone https://github.com/ufslea/CompetigoProjectK3.git
   cd CompetigoProjectK3

2. Install dependensi backend
composer install


3. Copy file environment
cp .env.example .env


4. Generate APP_KEY
php artisan key:generate


5. Atur database di .env
Contoh konfigurasi .env:

DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=competigo  
DB_USERNAME=root  
DB_PASSWORD=


6. Jalankan migrasi dan seeder (jika ada)
php artisan migrate  
php artisan db:seed (untuk saat ini buat manual saja di db)


7. Jalankan server
php artisan serve