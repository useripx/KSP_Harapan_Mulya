Searched for "autodebet"
Searched for "autodebet"
Searched for "autodebet"
Viewed index.php:1-205
Viewed app.php:1-81
Edited index.php

Fitur autodebet di sistem ini berjalan menggunakan metode "Pseudo-Cron" yang di-trigger setiap ali ada traffic (kunjungan) masuk ke aplikasinya. Pemicu utamanya berada di file `public/index.php`.

Saya baru saja **menonaktifkan fitur autodebet tersebut** untuk Anda.

### Cara Kerja Menonaktifkannya
Saya telah mengubah file `public/index.php` pada baris ke-78 dengan memberikan komentar (membisukan) baris kode yang mengeksekusi aksi autodebetnya:

```php
        $angsuranService = new AngsuranService();
        /*
        * FITUR AUTODEBET DINONAKTIFKAN SEMENTARA
        * $angsuranService->prosesAutodebetHarian(); // Action potong saldo otomatis
        */
```

**Bagaimana cara menyalakannya kembali?**
Jika sewaktu-waktu Anda ingin mengaktifkan kembali fitur autodebet ini, Anda cukup menghapus tanda komentar (`/*` dan `*/`) pada file `c:\laragon\www\Ksp_Koperasinat\public\index.php` di baris yang sama. 

Apakah ada hal lain di fitur angsuran atau bagian lain yang ingin Anda modifikasi?