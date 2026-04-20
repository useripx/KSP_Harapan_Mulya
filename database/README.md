# Direktori Database

Berisi file skrip SQL untuk mendefinisikan struktur database dan data awal (pancingan).

## File Database

- `schema.sql`: Berisi perintah `CREATE TABLE` untuk membangun struktur database dari nol.
- `seed.sql`: Berisi data dummy (anggota, transaksi, user) untuk keperluan testing aplikasi.

> [!NOTE]
> **Penting**: Semua default user (`admin`, `teller1`, dll) menggunakan password `password123`. Jika login gagal, pastikan hash di kolom `password_hash` database sudah sesuai (BCRYPT).
