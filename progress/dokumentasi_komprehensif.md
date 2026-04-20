# Dokumentasi Keseluruhan Proyek KSP Harapan Mulya

Dokumen ini merangkum *roadmap*, fitur-fitur, dan keseluruhan *update* pengembangan aplikasi Sistem Informasi Koperasi Simpan Pinjam (KSP) Harapan Mulya yang telah dijalankan dari tahap awal pembangunan hingga tahap penyempurnaan akhir.

---

## 🏗️ 1. Arsitektur & Teknologi Dasar
Aplikasi ini dibangun menggunakan arsitektur perangkat lunak yang mementingkan keamanan dan skalabilitas logis:
- **Pola Desain**: *Model-View-Controller* (MVC) murni berbasis *Vanilla PHP*.
- **Database**: MySQL dengan memanfaatkan *View* untuk kalkulasi otomatis dan menjaga integritas data tanpa redundansi (misalnya `v_saldo_simpanan`).
- **Antarmuka (Frontend)**: Menggunakan kerangka kerja Bootstrap dengan paduan ikon Bootstrap (BI), yang merespons layar secara adaptif (*mobile-friendly*).
- **Konsep Keamanan**: Implementasi OOP (*Object-Oriented Programming*), `PDO Prepared Statements` untuk mencegah SQL *Injection*, serta proteksi halaman berbasis sesi pengguna (*Session Role Base*).

---

## 🎭 2. Fitur Role-Based Access Control (RBAC)
Aplikasi membagi alur kerja koperasi secara aman melalui perizinan bertingkat bagi 4 entitas operasional utama:
1. **Admin / Superadmin**: Memiliki hak kendali mutlak untuk mengatur data staf, konfigurasi sistem, dan manajemen *user* tingkat dewa.
2. **Anggota**: Portal individual bagi nasabah koperasi. Bisa melihat riwayat tabungan pribadi, melacak sisa utang bulanan, dan melakukan inisiasi pengajuan pinjaman dari rumah.
3. **Teller**: Garda terdepan pendaftaran transaksi harian. Hanya `Teller` yang dapat melakukan mutasi simpanan fisik (Setor, Tarik), serta mencairkan uang tunai pinjaman yang telah disahkan.
4. **Ketua**: Pimpinan koperasi. Memiliki otoritas eksklusif untuk mengeklik tombol `Approve` atau `Reject` pada pengajuan pinjaman berskala besar, yang sudah melewati validasi dasar dari *teller*.

---

## 💰 3. Modul Simpanan & Arus Transaksi
Fitur ini telah disempurnakan demi akurasi *Zero-Error* pada kalkulasi uang member koperasi:
- **Jenis Transaksi**: Setor Tunai, Tarik Tunai, dan Transfer Antar-Member.
- **Validasi Anti-Minus (Saldo Akurat)**: Sebelumnya kalkulasi saldo hanya direkam secara manual, sekarang seluruh nominal simpanan adalah hasil kalkulasi *Real-time Database View* (`v_saldo_simpanan`). Sistem menolak secara otomatis mutasi yang melebihi batas simpanan anggota.

---

## 📊 4. Modul Manajemen Pinjaman & Angsuran (Update Signifikan)
Dari awal pengembangan hingga tahap akhir, alur pencairan utang telah diatur sedemikian rupa:
- **Flow Hirarkis (Alur Birokrasi)**: 
  `PENGAJUAN -> VERIFIKASI (Teller) -> APPROVAL (Ketua) -> PENCAIRAN (Teller)`
- **Sistem Analitik AI (Credit Scoring)**: Sebelum disetujui, Ketua akan disuguhkan dasbor saran pintar dari AI yang mengkalkulasi skor kelayakan (0-100 poin) anggota berdasarkan rekam jejak denda pembayaran minggu lalu, rasio tabungan, dan tunggakan berjalan agar koperasi terhindar dari kredit macet.
- **Perbaikan Tabel History/Jejak Audit**: Telah ditambahkan kolom kritikal (`verifikasi_oleh`, `approve_oleh`, `cair_oleh`) ke *database* agar admin bisa melacak kapan dan siapa staf yang bertanggung jawab mencairkan pinjaman tertentu.
- **Sistem Amortisasi (Cicilan)**: Ketika `Teller` menekan tombol "Cairkan", sistem secara pintar memecah utang menjadi hitungan `Tabel Amortisasi / Jadwal Angsuran` bulanan (lengkap dengan pokok pinjaman + perhitungan bunga *flat* proporsional).

---

## 🤖 5. Terobosan "Autodebet Angsuran Jatuh Tempo"
Fitur pamungkas yang baru saja sukses dikembangkan secara revolusioner untuk KSP:
- **Masalah Awal**: Teller kesulitan menagih member secara manual/harus menunggu kedatangan member ke kantor.
- **Solusi Cerdas**: Sistem `Autodebet` alias potong saldo harian.
- **Cara Kerja (Implementasi Pseudo-cron)**: 
  Sistem diprogram ulang di pangkalan utama aplikasi (`index.php`). Setiap hari, ketika ada satu saja *traffic* (kunjungan) masuk dari user manapun ke aplikasi, sistem web otomatis berjalan di "belakang layar" (Background Job). Skrip akan mendeteksi seluruh jadwal `BELUM_BAYAR` yang jatuh tempo hari itu.
- **Logika Eksekusi Validasi**: Jika *saldo* pengguna terkait dirasa lebih banyak/cukup dibanding nominal total tagihannya, maka bot *Autodebet* menekan tombol "TARIK" simpanannya, mamasukkannya ke kas, dan mengubah status pinjamannya sekejap mata menjadi `LUNAS`!

---

## 🖨️ 6. Modul Laporan Dinamis & Cetak PDF
Inovasi terbaru pada lapis presentasi (Admin, Ketua, Teller):
- **Filter Periode Multi-Dimensi**: Menu Laporan (Simpanan, Pinjaman, Angsuran, Arus Kas) kini diperbarui dengan filter tanggal interaktif. Pengguna bisa mensortir data berdasarkan waktu spesifik: **Harian**, **Bulanan**, maupun **Tahunan** hanya dengan satu klik *dropdown*.
- **Integrasi Arus Kas Utama**: *Database engine* menarik pembukuan komprehensif dari pencairan utang, cicilan yang dibayar, dll ke satu pintu `KAS_MASUK` & `KAS_KELUAR` secara sentral.
- **Cetak Instan Ber-Kop (Production Print Layout)**: Ditanamkan mode cetak responsif. Ketika opsi "Cetak PDF" ditekan, aplikasi secara ajaib menyulap tampilan tabel di layar menjadi dokumen resmi siap-kertas A4 (menyembunyikan sidebar, bilah menu, dan menggantinya dengan Kop Surat Koperasi).

---

## 🎨 7. Pembaruan UX: Dashboard Dinamis & Notifikasi Sistem
Demi menyajikan standar kelas perbankan komersial, UI/UX anggota telah dilukis ulang:
- **Card Dashboard Khusus Anggota**: Tersedia antarmuka khusus (memisahkan saldo, setoran masuk, penarikan, dan sisa beban cicilan) yang 100% responsif menirukan kartu aplikasi *Mobile Banking*.
- **Progress Stepper Pinjaman**: Timeline animasi `Diterima -> Verifikasi -> Pencairan` mereduksi status teks membosankan menjadi visual tracker garis biru.
- **Sistem Notifikasi Glow Dot (Premium UX)**: 
  - Mengganti angka notifikasi yang mengganggu dengan **Indikator Cahaya (Dot)**. 
  - **Merah Berdenyut (Pulse)**: Ada pesan baru belum dibaca. 
  - **Hijau Tenang**: Semua pesan sudah dibaca. 
  - Melibatkan animasi CSS modern dan pembaruan instan via AJAX tanpa *reload* halaman.
  - **Manajemen FIFO (First-In-First-Out)**: Database hanya menyimpan maksimal 5 notifikasi terbaru per user untuk efisiensi sistem. Jika ada pesan ke-6, pesan terlama otomatis dihapus.
  - **Cakupan Notifikasi**: Otomatis terkirim saat Setor Simpanan, Tarik Simpanan (Baru), Pengajuan Pinjaman, Verifikasi, Approval, hingga Pencairan.

---

- **Optimalisasi Mobile Responsiveness**: Perbaikan total pada *Sidebar Toggle* dan *Topbar Alignment* untuk perangkat layar kecil (HP/Tablet), memastikan navigasi tetap mulus di resolusi di bawah 992px.
- **Pembersihan Layout Dashboard**: Menghapus redundansi *header/footer* pada dashboard anggota (Double Layout Fix) sehingga tampilan lebih *clean* dan presisi.
- **Aturan Bisnis Baru**: Penyesuaian batas minimal Setor Simpanan menjadi **Rp 10.000** (dari sebelumnya Rp 500.000) untuk meningkatkan aksesibilitas bagi anggota.
- **Housekeeping (Pembersihan)**: Telah merapikan dan menghapus lebih dari 100+ file detektif/uji coba PHP mentah (*dummy dumps, logs files*) dari *root folder*, memastikan aplikasi *production-ready* dan siap-*deploy*.

---
*Dokumentasi ini disusun oleh Pengembang KSP, berisikan semua fitur hingga rilis April 2026. Aplikasi KSP Harapan Mulya Anda sekarang berada dalam status optimal, matang, dan siap meluncur ke aktivitas operasional.*
