# Direktori Core (Inti)

Folder ini adalah jantung dari sistem (Engine Project). Berisi kelas-kelas dasar yang di-extend oleh komponen lain.

## Komponen Core

- `Router.php`: Menangani sistem Routing (URL Parsing, parameter, dan middleware). **Update**: Ditambahkan filter parameter untuk kompatibilitas PHP 8 (Named Arguments conflict fix).
- `Controller.php`: Base Controller yang menyediakan fungsi helper seperti `view()`, `redirect()`, `json()`, dan asset management.
- `Model.php`: Base Model yang mengintegrasikan query builder sederhana dan interaksi database via PDO.
- `View.php`: Mengelola rendering template, parsing data ke view, dan helper UI seperti `isActive()`.
- `Auth.php`: Menangani session, otentikasi user, proteksi route (`intended()`), dan otorisasi berbasis Role.
