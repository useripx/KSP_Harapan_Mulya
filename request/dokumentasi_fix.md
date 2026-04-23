# 🛠️ Dokumentasi Fix — Error Dashboard Manager
**File:** `request/dokumentasi_fix.md`  
**Error:** `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'a.id' in 'where clause'`  
**Terjadi di:** `DashboardController.php` line 148 — saat login sebagai Manager

---

## 📌 Penjelasan Error

Error ini terjadi karena **perbedaan versi MySQL**:

| PC | Server | MySQL | Status |
|----|--------|-------|--------|
| PC Utama (Laragon) | Apache | MySQL **8.x** | ✅ Berjalan normal |
| PC Teman (XAMPP) | Apache | MySQL **5.7.x** | ❌ Error |

### Kenapa Beda?
Query di `DashboardController.php` menggunakan **correlated subquery di dalam derived table** (subquery bersarang). MySQL 8.x mendukung ini, tetapi **MySQL 5.7.x tidak mengizinkan** referensi alias tabel luar (`a.id`) di dalam subquery yang bertingkat:

```sql
-- BAGIAN BERMASALAH di MySQL 5.7:
(
    SELECT MAX(tgl) FROM (
        SELECT tanggal as tgl FROM simpanan_transaksi WHERE anggota_id = a.id  -- ← a.id tidak dikenal di sini!
        UNION
        SELECT created_at as tgl FROM pinjaman WHERE anggota_id = a.id
        UNION
        SELECT tanggal_bayar as tgl FROM angsuran ans
            JOIN pinjaman p ON ans.pinjaman_id = p.id
            WHERE p.anggota_id = a.id
    ) as akt
) as aktivitas_terakhir
```

---

## ✅ Cara Memperbaiki

### Langkah 1 — Buka File

Buka file:
```
C:\test xampp\htdocs\Ksp_Koperasinat\app\controllers\DashboardController.php
```

### Langkah 2 — Cari Kode Bermasalah

Cari blok query di sekitar **baris 127–146** yang terlihat seperti ini:

```php
// Member Summary Table Data
$sql = "
    SELECT 
        a.no_anggota, 
        a.nama, 
        (SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = a.id) as iuran,
        (SELECT COALESCE(SUM(sisa_pokok), 0) FROM v_ringkasan_pinjaman WHERE anggota_id = a.id AND status IN ('BERJALAN', 'DICAIRKAN')) as cicilan,
        (
            SELECT MAX(tgl) FROM (
                SELECT tanggal as tgl FROM simpanan_transaksi WHERE anggota_id = a.id
                UNION
                SELECT created_at as tgl FROM pinjaman WHERE anggota_id = a.id
                UNION
                SELECT tanggal_bayar as tgl FROM angsuran ans JOIN pinjaman p ON ans.pinjaman_id = p.id WHERE p.anggota_id = a.id
            ) as akt
        ) as aktivitas_terakhir
    FROM anggota a
    WHERE a.status = 'AKTIF'
    ORDER BY aktivitas_terakhir DESC
    LIMIT 50
";

$ringkasanAnggota = $db->query($sql)->fetchAll();
```

### Langkah 3 — Ganti dengan Query yang Kompatibel

**Hapus** seluruh blok `$sql = "...";` dan `$ringkasanAnggota = ...;` di atas, lalu **ganti** dengan kode berikut:

```php
// Member Summary Table Data — compatible dengan MySQL 5.7 & 8.x
$sql = "
    SELECT 
        a.no_anggota,
        a.nama,
        COALESCE(vss.saldo, 0) as iuran,
        COALESCE(vr.sisa_pokok_total, 0) as cicilan,
        GREATEST(
            COALESCE(MAX(st.tanggal), '1970-01-01'),
            COALESCE(MAX(p2.created_at), '1970-01-01'),
            COALESCE(MAX(ans.tanggal_bayar), '1970-01-01')
        ) as aktivitas_terakhir
    FROM anggota a
    LEFT JOIN v_saldo_simpanan vss ON vss.anggota_id = a.id
    LEFT JOIN (
        SELECT anggota_id, SUM(sisa_pokok) as sisa_pokok_total
        FROM v_ringkasan_pinjaman
        WHERE status IN ('BERJALAN', 'DICAIRKAN')
        GROUP BY anggota_id
    ) vr ON vr.anggota_id = a.id
    LEFT JOIN simpanan_transaksi st ON st.anggota_id = a.id
    LEFT JOIN pinjaman p2 ON p2.anggota_id = a.id
    LEFT JOIN angsuran ans ON ans.pinjaman_id = p2.id
    WHERE a.status = 'AKTIF'
    GROUP BY a.id, a.no_anggota, a.nama, vss.saldo, vr.sisa_pokok_total
    ORDER BY aktivitas_terakhir DESC
    LIMIT 50
";

$ringkasanAnggota = $db->query($sql)->fetchAll();
```

---

## 📋 Perbandingan Kode (Before vs After)

### ❌ Sebelum (error di MySQL 5.7)
```php
$sql = "
    SELECT 
        a.no_anggota, 
        a.nama, 
        (SELECT saldo FROM v_saldo_simpanan WHERE anggota_id = a.id) as iuran,
        (SELECT COALESCE(SUM(sisa_pokok), 0) FROM v_ringkasan_pinjaman WHERE anggota_id = a.id AND status IN ('BERJALAN', 'DICAIRKAN')) as cicilan,
        (
            SELECT MAX(tgl) FROM (
                SELECT tanggal as tgl FROM simpanan_transaksi WHERE anggota_id = a.id
                UNION
                SELECT created_at as tgl FROM pinjaman WHERE anggota_id = a.id
                UNION
                SELECT tanggal_bayar as tgl FROM angsuran ans JOIN pinjaman p ON ans.pinjaman_id = p.id WHERE p.anggota_id = a.id
            ) as akt
        ) as aktivitas_terakhir
    FROM anggota a
    WHERE a.status = 'AKTIF'
    ORDER BY aktivitas_terakhir DESC
    LIMIT 50
";
$ringkasanAnggota = $db->query($sql)->fetchAll();
```

### ✅ Sesudah (kompatibel MySQL 5.7 & 8.x)
```php
$sql = "
    SELECT 
        a.no_anggota,
        a.nama,
        COALESCE(vss.saldo, 0) as iuran,
        COALESCE(vr.sisa_pokok_total, 0) as cicilan,
        GREATEST(
            COALESCE(MAX(st.tanggal), '1970-01-01'),
            COALESCE(MAX(p2.created_at), '1970-01-01'),
            COALESCE(MAX(ans.tanggal_bayar), '1970-01-01')
        ) as aktivitas_terakhir
    FROM anggota a
    LEFT JOIN v_saldo_simpanan vss ON vss.anggota_id = a.id
    LEFT JOIN (
        SELECT anggota_id, SUM(sisa_pokok) as sisa_pokok_total
        FROM v_ringkasan_pinjaman
        WHERE status IN ('BERJALAN', 'DICAIRKAN')
        GROUP BY anggota_id
    ) vr ON vr.anggota_id = a.id
    LEFT JOIN simpanan_transaksi st ON st.anggota_id = a.id
    LEFT JOIN pinjaman p2 ON p2.anggota_id = a.id
    LEFT JOIN angsuran ans ON ans.pinjaman_id = p2.id
    WHERE a.status = 'AKTIF'
    GROUP BY a.id, a.no_anggota, a.nama, vss.saldo, vr.sisa_pokok_total
    ORDER BY aktivitas_terakhir DESC
    LIMIT 50
";
$ringkasanAnggota = $db->query($sql)->fetchAll();
```

---

## 🔍 Kenapa Query Baru Ini Bisa Jalan?

| Aspek | Query Lama | Query Baru |
|-------|-----------|-----------|
| Metode akivitas terakhir | Subquery bersarang (correlated) | `GREATEST()` + `LEFT JOIN` + `GROUP BY` |
| Isu MySQL 5.7 | ❌ Tidak bisa referensi `a.id` di nested subquery | ✅ Semua JOIN di level yang sama |
| Performa | Untuk tiap baris jalankan 3 subquery | ✅ Satu kali JOIN, lebih efisien |
| Hasil tampilan | Sama | Sama |

---

## 📍 Lokasi Persis di File

Buka file `DashboardController.php`, cari bagian ini (sekitar baris 127):

```php
private function renderManagerDashboard()
{
    $db = db();

    // Get statistics (Tunggakan is removed per requirement)
    $stats = [ ... ];

    // Member Summary Table Data      ← CARI BARIS INI
    $sql = "
        SELECT ...                    ← GANTI DARI SINI
        ...
    ";
    $ringkasanAnggota = $db->query($sql)->fetchAll();   ← SAMPAI SINI (inklusif)
```

---

## ✔️ Verifikasi Setelah Fix

1. Simpan file `DashboardController.php`
2. Refresh browser / clear cache (Ctrl+F5)
3. Login ulang sebagai `ketua` / `password123`
4. Dashboard Manager seharusnya tampil dengan tabel anggota

**Jika masih error**, cek apakah views `v_saldo_simpanan` dan `v_ringkasan_pinjaman` sudah ada di database:
```sql
-- Jalankan di phpMyAdmin atau HeidiSQL
SHOW FULL TABLES IN ksp_koperasinat WHERE TABLE_TYPE LIKE 'VIEW';
```
Output yang benar harus menampilkan: `v_saldo_simpanan`, `v_ringkasan_pinjaman`, `v_tunggakan`

Jika view tidak ada, import ulang dari `database/schema.sql` (bagian CREATE VIEW).

---

*Dibuat untuk: Tim Koperasi Harapan Mulya — Fix kompatibilitas MySQL 5.7 vs 8.x*
