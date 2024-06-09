<img src="https://banners.beyondco.de/RENO.png?theme=dark&packageManager=composer+require&packageName=hanzo-alpha%2Fsimdata-sosial&pattern=brickWall&style=style_1&description=Rumah+Data+Terpadu+Dinas+Sosial&md=1&showWatermark=1&fontSize=100px&images=presentation-chart-bar">

<div align="center">

![GitHub Issues or Pull Requests](https://img.shields.io/github/issues-pr/hanzo-alpha/simdata-sosial?style=flat-square)
![GitHub Issues or Pull Requests](https://img.shields.io/github/issues/hanzo-alpha/simdata-sosial?style=flat-square)
![GitHub Downloads (all assets, all releases)](https://img.shields.io/github/downloads/hanzo-alpha/simdata-sosial/total?style=flat-square)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/hanzo-alpha/simdata-sosial/run-tests.yml?event=push&style=flat-square)
![GitHub Release](https://img.shields.io/github/v/release/hanzo-alpha/simdata-sosial?display_name=release&style=flat-square)
![GitHub License](https://img.shields.io/github/license/hanzo-alpha/simdata-sosial?style=flat-square)

</div>


## Tentang RENO

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
5. Silahkan buka di web browser anda : ```http://localhost/admin``` atau ```https://your-local-domain.local```
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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

If you discover a security vulnerability within RENO, please send an e-mail to Hanzo Alpha
via [hansen.makangiras@hotmail.com](mailto:hanzo.asashi.dev@gmail.com). All security vulnerabilities will be promptly
addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
