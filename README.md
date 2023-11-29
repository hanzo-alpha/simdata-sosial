<p align="center"><a href="https://github.com/hanzo-alpha/simdata-sosial" target="_blank"><img src="https://banners.beyondco.de/SIMDADU.png?theme=dark&packageManager=composer+require&packageName=hanzo-alpha%2Fsimdata-sosial&pattern=brickWall&style=style_1&description=Sistem+Informasi+Rumah+Data+Terpadu&md=1&showWatermark=1&fontSize=100px&images=home" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/hanzo-alpha/simdata-sosial"><img src="https://img.shields.io/github/downloads/hanzo-alpha/simdata-sosial/total" alt="Total Downloads"></a>
<a href="https://github.com/hanzo-alpha/simdata-sosial"><img src="https://img.shields.io/github/issues-pr/hanzo-alpha/simdata-sosial
" alt="Pull Request Open"></a>
<a href="https://github.com/hanzo-alpha/simdata-sosial"><img src="https://img.shields.io/github/license/hanzo-alpha/simdata-sosial?style=flat-square&logo=mit" alt="License"></a>
</p>

## Tentang SIMDADU

Sistem Informasi Managemen Rumah Data Terpadu merupakan aplikasi kemiskinan untuk mendata keluarga atau penerima
manfaat yang layak untuk mendapatkan bantuan dari pemerintah.

## Install / Setup

1. Install menggunakan composer, diasumsikan anda sudah menginstall dan konfigurasi composer, lalu ketikkan :
    ``` 
    composer install
    ```

2. Install asset menggunakan npm, buka terminal / windows terminal atau sejenisnya lalu ketikkan :
    ````
    npm install
    ````
3. Jalankan perintah berikut untuk migrasi database :
   ````
   php artisan migrate
   ````
4. Jalankan perintah berikut pada terminal kesayangan anda untuk mengimport data default :
    ````
   php artisan db:seed
   ````
5. Silahkan buka di web browser anda : ```https://localhost/admin``` atau ```https://simdata-sosial.local```
   jika anda menggunakan domain pada lokal development anda. Untuk login ke aplikasi bisa menggunakan akun berikut :
    ````
   email : sadmin@simdata-sosial.local
   password : password
   ````
   Jika tidak berhasil masuk dengan akun diatas, silahkan buat user sendiri dengan perintah berikut :
   ````
   php artisan make:filament-user
   ````
   Lalu lanjutkan mengisi data user anda.
6. Setelah itu ketik perintah berikut:
    ````
   php artisan shield:install
    ````
   Setelah berhasil ketik perintah berikut:
    ````
   php artisan shield:generate --all
    ````

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Hanzo Alpha via [hanzo.
asashi.dev@gmail.com]
(mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
