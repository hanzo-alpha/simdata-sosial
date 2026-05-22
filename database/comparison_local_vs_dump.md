# Perbandingan Database Lokal vs Dump

Sumber pembanding:

- Dump: `database/u620101454_renos - Copy - MySQL8.sql`
- Database lokal: `simdata_sosial`

## Ringkasan

Database lokal **belum identik 100%** dengan file dump jika dibandingkan secara raw schema.

- Nama tabel cocok penuh: **61 / 61**
- Tidak ada tabel yang hilang atau bertambah
- Data pada tabel-tabel kunci sudah masuk dan cocok dengan dump
- Namun, definisi `CREATE TABLE` masih berbeda secara tekstual pada seluruh tabel karena perbedaan gaya output MySQL 8.4
  dan isi schema dump asli

## Perbedaan yang paling jelas

1. Live schema menuliskan `COLLATE utf8mb4_unicode_ci` di banyak kolom, sedangkan dump lama tidak menuliskannya di
   setiap kolom.
2. Live schema memakai tipe integer tanpa display width, misalnya `bigint unsigned` atau `int unsigned`, sedangkan dump
   lama sering memakai format `bigint(20) unsigned` atau `int(10) unsigned`.
3. Beberapa tabel pada dump asli punya `CHECK (json_valid(...))`, tetapi saat di-load ke MySQL lokal bagian itu tidak
   dipertahankan karena dump aslinya bermasalah untuk server ini.

## Tabel dengan beda struktur yang paling penting

Tabel berikut adalah yang paling relevan karena terkait constraint JSON/check yang berubah:

- `activity_log`
- `banners`
- `bantuan_ppks`
- `bantuan_rastra`
- `berita_acara`
- `detail_bantuan_ppks`
- `failed_import_rows`
- `pengganti_rastra`
- `penyaluran_bantuan_ppks`
- `penyaluran_bantuan_rastra`

## Status data

Data sudah masuk dan cocok untuk tabel-tabel yang dicek ulang, misalnya:

- `bansos_diterima` = 21
- `bantuan_bpjs` = 362
- `bantuan_bpnt` = 15.618
- `bantuan_pkh` = 10.600
- `bantuan_rastra` = 1.386
- `berita_acara` = 134
- `pengganti_rastra` = 16
- `penyaluran_bantuan_ppks` = 139
- `penyaluran_bantuan_rastra` = 2.764
- `users` = 76

## Kesimpulan

- **Identik 100%:** tidak
- **Data masuk:** ya
- **Schema raw identik:** tidak, ada perbedaan format dan beberapa constraint

Jika ingin, langkah berikutnya adalah membuat perbandingan per tabel untuk mencari mana yang hanya beda format dan mana
yang benar-benar beda struktur bisnis.
