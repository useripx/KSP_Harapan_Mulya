# Direktori App (Aplikasi)

Folder ini berisi logika inti aplikasi (Core Logic) yang mengikuti pola arsitektur MVC (Model-View-Controller).

## Struktur Folder

- `config/`: Berisi file konfigurasi aplikasi (Database, App Config, dll).
- `controllers/`: Berisi logika untuk menangani request dari pengguna dan mengembalikan data ke view.
- `core/`: Berisi sistem inti aplikasi seperti Router, Controller dasar, Model dasar, dan sistem Autentikasi.
- `helpers/`: Berisi fungsi-fungsi pembantu (utility functions) yang digunakan di seluruh aplikasi.
- `jobs/`: Berisi tugas-tugas yang berjalan di latar belakang (background tasks/cron jobs).
- `middleware/`: Berisi layer keamanan atau filter sebelum request diproses oleh controller.
- `models/`: Berisi logika interaksi dengan database untuk setiap tabel.
- `services/`: Berisi logika bisnis (Business Logic) yang lebih kompleks yang dipisahkan dari controller.
