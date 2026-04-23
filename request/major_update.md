# 🚀 MAJOR UPDATE — Koperasi Harapan Mulya v17
**Tanggal Rilis:** 21 April 2026  
**Berlaku dari Versi:** 16 → 17  

---

## ⚠️ PENTING: Baca Dulu Sebelum Install

Versi 17 ini memperkenalkan **perubahan breaking** pada sistem role pengguna.  
Jika tim Anda:
- **Setup di PC baru** → ikuti Bagian A (Setup Fresh)
- **Update dari versi lama yang sudah jalan** → ikuti Bagian B (Update Existing)

---

## BAGIAN A — SETUP DI PC BARU (Fresh Install)

### Prasyarat
Pastikan PC sudah terinstall:
- ✅ **Laragon** (atau XAMPP/WAMP) dengan PHP 8.x + MySQL 8.x
- ✅ **Git** (opsional, untuk clone repo)
- ✅ **Browser** (Chrome/Firefox/Edge)

---

### Langkah 1 — Siapkan File Proyek

Salin folder proyek ke direktori web server:
```
C:\laragon\www\Ksp_Koperasinat\
```
Pastikan struktur folder seperti berikut:
```
Ksp_Koperasinat/
├── app/
│   ├── config/
│   ├── Controllers/
│   ├── core/
│   ├── helpers/
│   └── models/
├── database/
│   ├── ksp_koperasinat.sql       ← file dump yang sudah Anda siapkan
│   ├── migrate_roles_fix.sql     ← migration role (WAJIB dijalankan)
│   └── schema.sql
├── public/
│   ├── assets/
│   │   └── img/
│   │       └── img.png           ← logo institusi
│   └── index.php
├── views/
├── .env                          ← WAJIB dikonfigurasi
└── request/
    └── major_update.md           ← file ini
```

---

### Langkah 2 — Import Database

Buka terminal / Command Prompt, lalu:

```bash
# 1. Buat database (jika belum ada)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS ksp_koperasinat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Import dump database lama
mysql -u root ksp_koperasinat < database/ksp_koperasinat.sql
```

**PowerShell (jika memakai Windows):**
```powershell
# Buat database
echo "CREATE DATABASE IF NOT EXISTS ksp_koperasinat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" | mysql -u root

# Import dump
Get-Content "database\ksp_koperasinat.sql" | mysql -u root ksp_koperasinat
```

> ⚠️ **JANGAN LEWATI langkah 3 di bawah ini!** File SQL lama masih memakai role ADMIN/TELLER/KETUA yang sudah tidak berlaku.

---

### Langkah 3 — Jalankan Migration Role (WAJIB)

Setelah import selesai, jalankan migration untuk mengubah role ke format baru:

```powershell
Get-Content "database\migrate_roles_fix.sql" | mysql -u root ksp_koperasinat
```

Output yang benar:
```
status
Migrasi role selesai!
role       jumlah
VALIDATOR  X
BAU        X
MANAGER    X
ANGGOTA    X
```

> Jika output tidak menampilkan `VALIDATOR/BAU/MANAGER`, berarti migration gagal. Coba ulangi perintah di atas.

---

### Langkah 4 — Konfigurasi .env

Edit file `.env` di root proyek:

```env
# Environment
APP_ENV=development
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta

# !! SESUAIKAN URL dengan path di PC Anda
BASE_URL=http://localhost/Ksp_Koperasinat/public/

# Database — sesuaikan jika berbeda
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=ksp_koperasinat
DB_USER=root
DB_PASS=           ← isi jika MySQL Anda punya password

# Session
SESSION_LIFETIME=7200
SESSION_NAME=KSP_SESSION

# Security
CSRF_TOKEN_NAME=csrf_token
HASH_ALGO=PASSWORD_BCRYPT
```

---

### Langkah 5 — Verifikasi Instalasi

1. Buka browser → `http://localhost/Ksp_Koperasinat/public/login`
2. Login dengan akun salah satu di bawah:

| Username | Password | Role |
|----------|----------|------|
| `admin` | `password123` | Validator |
| `teller1` | `password123` | BAU |
| `ketua` | `password123` | Manager |
| `ahmad` | `password123` | Anggota |

3. Setelah login berhasil, Anda akan diarahkan ke URL berikut sesuai role:

| Role | URL Dashboard |
|------|--------------|
| Validator | `/validator` |
| BAU | `/bau` |
| Manager | `/manager` |
| Anggota | `/anggota/dashboard` |

---

## BAGIAN B — UPDATE DI PC YANG SUDAH JALAN

### Prasyarat
- Database `ksp_koperasinat` sudah ada dan berjalan
- Aplikasi versi lama sudah bisa diakses

### Langkah 1 — Pull / Salin File Kode Baru

Salin/replace semua file proyek kecuali `.env` (jangan timpa `.env` Anda sendiri).

### Langkah 2 — Jalankan Migration Role

```powershell
# Di direktori proyek (Ksp_Koperasinat)
Get-Content "database\migrate_roles_fix.sql" | mysql -u root ksp_koperasinat
```

### Langkah 3 — Hapus Session Lama

User yang sudah login dengan sistem lama akan error karena session menyimpan role format lama (`ADMIN`, `KETUA`, dll). Solusinya:

**Opsi A (Semua user):** Restart session PHP di Laragon:
```powershell
# Hapus file session PHP di temp
Get-ChildItem "$env:TEMP" -Filter "sess_*" | Remove-Item -Force -ErrorAction SilentlyContinue
```

**Opsi B (Per user):** Minta masing-masing pengguna:
1. Buka browser → Ctrl+Shift+Delete
2. Pilih "Cookies and site data" untuk `localhost`
3. Hapus, lalu login ulang

---

## RINGKASAN PERUBAHAN v16 → v17

### 🔐 Perubahan Sistem Role

```
SEBELUM          SESUDAH
--------         --------
ADMIN    →       VALIDATOR
TELLER   →       BAU
KETUA    →       MANAGER
ANGGOTA  →       ANGGOTA (tidak berubah)
```

**Dampak pada kode:**
- `app/config/constants.php` → nilai konstanta `ROLE_ADMIN`/`ROLE_TELLER`/`ROLE_KETUA` diubah
- Karena seluruh kode menggunakan *konstanta* (bukan hardcode string), hanya file constants.php yang perlu diubah

### 📊 Dashboard Manager — Redesign Total

| Fitur | Status |
|-------|--------|
| Kartu Total Tunggakan | ❌ Dihapus |
| Aksi Cepat (Setor, Tarik, Pinjaman, Angsuran) | ❌ Dihapus |
| Grafik Status Pinjaman | ❌ Dihapus |
| Tabel Ringkasan Anggota (No, Nama, Iuran, Cicilan, Aktivitas) | ✅ Ditambahkan |
| Kartu stat 4 kolom | ✅ Dirubah jadi 3 kolom |

### 🎨 Identitas Visual

| Lokasi | Sebelum | Sesudah |
|--------|---------|---------|
| Login page — logo | Ikon Bootstrap `bi-bank2` | Gambar `img.png` (130×130px) |
| Sidebar — logo | Ikon Bootstrap `bi-bank2` | Gambar `img.png` |
| Tab browser (favicon) | Tidak ada | `img.png` |

### 🔗 Perubahan URL Route

| Sebelum | Sesudah | Keterangan |
|---------|---------|------------|
| `/admin` | `/validator` | Dashboard Validator (alias lama tetap berfungsi) |
| `/teller` | `/bau` | Dashboard BAU (alias lama tetap berfungsi) |
| `/ketua` | `/manager` | Dashboard Manager (alias lama tetap berfungsi) |

---

## FILE YANG BERUBAH

### File Dimodifikasi
```
app/
  config/constants.php              ← nilai konstanta role baru
  core/Auth.php                     ← requireRole() default redirect
  Controllers/AuthController.php    ← URL redirect pasca-login
  Controllers/DashboardController.php ← manager dashboard method + query

public/
  index.php                         ← route URL baru /validator /bau /manager

views/
  layout/sidebar.php                ← link dashboard + logo img.png
  layout/main.php                   ← favicon
  auth/login.php                    ← logo img.png + CSS compact
  dashboard/manager.php             ← redesign tampilan

database/
  schema.sql                        ← ENUM role baru
  seed.sql                          ← role seed data baru
```

### File Baru Dibuat
```
database/
  migrate_roles_fix.sql             ← ✅ Script migration utama (sudah dieksekusi di PC dev)
  migrate_roles.sql                 ← ⛔ Versi lama, jangan gunakan
```

---

## ISI `migrate_roles_fix.sql` (Untuk Referensi)

```sql
-- Langkah 1: Tambah ENUM baru (tanpa hapus yang lama dulu)
ALTER TABLE users
  MODIFY COLUMN role ENUM('ADMIN','TELLER','KETUA','ANGGOTA','VALIDATOR','BAU','MANAGER')
  NOT NULL DEFAULT 'ANGGOTA';

-- Langkah 2: Update data lama
UPDATE users SET role = 'VALIDATOR' WHERE role = 'ADMIN';
UPDATE users SET role = 'BAU'       WHERE role = 'TELLER';
UPDATE users SET role = 'MANAGER'   WHERE role = 'KETUA';

-- Langkah 3: Bersihkan ENUM lama
ALTER TABLE users
  MODIFY COLUMN role ENUM('VALIDATOR','BAU','MANAGER','ANGGOTA')
  NOT NULL DEFAULT 'ANGGOTA';
```

> [!WARNING]
> Jangan jalankan migration lebih dari sekali! Kalau sudah berhasil (cek dengan `SELECT role, COUNT(*) FROM users GROUP BY role;`), tidak perlu dijalankan lagi.

---

## TROUBLESHOOTING

### ❌ "The page isn't redirecting properly" saat login

**Penyebab:** Session lama masih menyimpan role format lama.  
**Solusi:** Hapus cookies browser untuk `localhost`, lalu login ulang.

### ❌ Password tidak cocok

**Penyebab:** Akun di database dump mungkin punya password berbeda.  
**Solusi:** Reset password via phpMyAdmin atau jalankan:
```sql
UPDATE users SET password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE username = 'admin';
-- Password menjadi: password123
```

### ❌ Logo tidak muncul di sidebar/login

**Penyebab:** File `public/assets/img/img.png` tidak tersalin.  
**Solusi:** Pastikan file `img.png` ada di `public/assets/img/`.

### ❌ Database error saat import

**Penyebab:** Karakter encoding atau versi MySQL berbeda.  
**Solusi:**
```powershell
mysql -u root --default-character-set=utf8mb4 ksp_koperasinat < database/ksp_koperasinat.sql
```

### ❌ "Role tidak valid" setelah login

**Penyebab:** Migration role belum dijalankan di PC ini.  
**Solusi:** Jalankan Langkah 3 (migration) di Bagian A atau B.

---

## KONTAK & REFERENSI

- Dokumen role lengkap: `request/role/rolenew.md`
- Instruksi rename role: `request/role/keterangan_role.md`
- Konfigurasi aplikasi: `.env`
- Migration script: `database/migrate_roles_fix.sql`

---
*Koperasi Harapan Mulya — Versi 17 — 21 April 2026*
