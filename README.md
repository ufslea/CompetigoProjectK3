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


8. Buat branch sendiri

Selalu bikin branch baru sebelum ngedit apa pun.

git checkout -b fitur-login-gwejh


9. Lakukan perubahan di VS Code

Setelah selesai, save semua file.


10. Cek perubahan apa aja yang dibuat

git status

akan nampilin file mana aja yang berubah (warna merah).

Kalau udah yakin, tambahkan ke staging area:

git add .

titik (.) = semua file yang berubah.

 Atau kalau mau spesifik:

git add app/Http/Controllers/LoginController.php


11. Commit 

git commit -m "Menambah fitur login"


12. Push ke GitHub

Upload branch ke GitHub (bukan main):

git push origin fitur-login-gwejh


13. Sinkronisasi dengan tim (supaya ga bentrok)
Sebelum mulai ngedit atau push ulang, SELALU lakukan:

git checkout main          # pindah ke main

git pull origin main       # ambil update terbaru dari GitHub

git checkout fitur-login-gwejh   # balik ke branch kita

git merge main             # gabungkan update terbaru ke branch kita
