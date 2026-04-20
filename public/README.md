# Direktori Publik (Public)

Folder ini adalah folder publik yang bisa diakses langsung lewat web browser. Ini adalah lokasi root dari web server.

## Struktur Public

- `index.php`: *Front Controller* - Semua request masuk lewat sini lalu diarahkan oleh Router.
- `assets/`: Berisi file statis aplikasi seperti CSS (Shadcn-style), JavaScript, dan Gambar.
- `uploads/`: Folder tempat menyimpan file yang diunggah oleh user (foto anggota, bukti transfer, dll).
- `.htaccess`: Konfigurasi Apache untuk *Friendly URL*. 

> [!TIP]
> **Penting**: File `.htaccess` dikonfigurasi tanpa `RewriteBase /` agar fleksibel saat aplikasi diletakkan di subfolder (seperti di `/Ksp_Koperasi/`).
