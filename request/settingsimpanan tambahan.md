# Rahasia di Balik Fitur Pencarian & Konfigurasi Simpanan

Fitur pencarian anggota (autocomplete) yang awalnya kosong hingga bisa berfungsi secara interaktif sebenarnya melibatkan beberapa lapis teknologi yang saling berkomunikasi. Berikut adalah langkah-langkah dan cara saya membangun fitur tersebut dari nol hingga menjadi sangat interaktif:

## 1. Menghubungkan Frontend ke Database (Backend Routing)
Awalnya, kotak pencarian di halaman pengaturan hanyalah elemen HTML biasa (mati). Langkah pertama yang saya lakukan adalah **membuka jalur komunikasi** ke database.
- Saya memastikan ada fungsi di `AnggotaController` bernama `search()` yang bertugas mencari nama atau nomor anggota menggunakan query `LIKE %keyword%`.
- Saya mendaftarkan jalur (URL) tersebut di file pusat `public/index.php` sehingga ketika halaman web memanggil `/api/anggota/search`, server tahu harus merespons dengan data anggota berformat JSON.

## 2. Mengatasi Masalah URL (Subfolder Routing)
Salah satu "bug" tersembunyi yang membuat fitur ini awalnya tidak jalan adalah masalah *pathing*. 
- Karena aplikasi Anda dijalankan di Laragon (sebuah subfolder: `localhost/Ksp_Koperasinat/public`), memanggil `/api/anggota/search` di JavaScript akan membuat browser mencari ke root server (`localhost/api/...`), sehingga data tidak pernah ditemukan (Error 404).
- **Solusinya:** Saya membungkus URL di JavaScript dengan fungsi PHP `<?= url() ?>`. Ini memastikan jalur API yang dipanggil selalu valid dan tepat sasaran, dimanapun aplikasinya di-hosting.

## 3. Membangun Logika Autocomplete yang Cerdas (JavaScript)
Setelah API terhubung, saya menulis logika JavaScript yang bertindak sebagai "otak" di balik kotak pencarian:
- **Teknik Debouncing:** Saya menggunakan trik bernama *debounce* (jeda 300ms). Saat Anda mengetik "Y-O-G-I", sistem tidak akan menembak database 4 kali. Sistem akan menunggu sampai Anda berhenti mengetik selama 0.3 detik, barulah mengirimkan 1 tembakan ke database. Ini membuat aplikasi sangat ringan dan tidak membebani server.
- **Rendering Dinamis:** Ketika data JSON diterima dari server, JavaScript akan menghapus isi dropdown lama, lalu membuat elemen `<button>` HTML baru secara dinamis untuk setiap nama anggota yang ditemukan, lengkap dengan ikon dan efek *hover* birunya.

## 4. Memaksa Dropdown Tampil (CSS & Z-Index)
Tantangan terbesar yang Anda lihat (saat Anda tandai hitam di *screenshot*) adalah *suggestions list* yang menolak muncul.
- **Masalahnya:** Elemen *dropdown* tertimpa oleh elemen UI lainnya, atau tidak memiliki instruksi tegas untuk menampakkan diri.
- **Solusinya:** Saya menyuntikkan *styling* absolut: `z-index: 9999 !important` (memaksanya berada di lapisan paling depan), memberikan `background: white` yang solid, memberikan bayangan (shadow) agar terlihat melayang (Google-style), dan memaksa JavaScript menyuntikkan `display: block` saat data ada.

## 5. Seleksi Anggota & *Auto-fill* Data
Pencarian tidak akan berguna jika tidak bisa dipilih. 
- Saya menanamkan *Event Listener* pada setiap nama yang muncul. Ketika diklik, beberapa hal terjadi secara instan:
  1. Kotak pencarian disembunyikan.
  2. Muncul nama anggota yang dipilih beserta tombol "X" (untuk membatalkan pilihan).
  3. JavaScript diam-diam menaruh ID anggota ke dalam input tersembunyi (`<input type="hidden" name="user_id">`) untuk dikirim saat formulir di-submit.
  4. JavaScript melakukan 1 *fetch* (pemanggilan) lagi ke `/api/settings/savings` untuk menarik data simpanan lama anggota tersebut dan secara otomatis mengisinya ke kolom "Simpanan Motor" dan "Simpanan Mobil" agar admin tidak perlu menebak nominal sebelumnya.

## 6. Sentuhan Akhir: Pop-Up Dinamis (SweetAlert2)
Untuk memberikan pengalaman (UX) yang *wow*, saya membuang notifikasi hijau bawaan yang membosankan.
- Di backend (`AuthController`), saat data berhasil disimpan, sistem akan merekam nama anggota dan nominal yang diinput ke dalam `$_SESSION`.
- Di frontend (`settings.php`), sebuah *script* akan mendeteksi *session* tersebut. Jika ada, ia akan merakit kalimat secara pintar (mengecek apakah admin mengisi motor saja, mobil saja, atau keduanya) dan memanggil modul `SweetAlert2` untuk menampilkan Pop-Up yang elegan dan informatif.
- Di saat yang sama, script ini diam-diam menghapus alert hijau bawaan agar tidak terjadi *double notification*.

## 7. Penyelamatan dari Bug Fatal (Hotfix Struktur Database)
Pada saat pengujian lebih lanjut, saya menemukan sebuah kejanggalan: anggota bernama "Eka Abbie" ditolak oleh sistem dan menyebabkan *error* "Pilih anggota terlebih dahulu".
- **Mengapa ini terjadi?** Tabel penyimpanan kita sebelumnya mengunci data ke `user_id` (ID Akun Login). Masalahnya, tidak semua anggota punya akun login (Eka Abbie memiliki `user_id = 0`). Di mata program (PHP), angka `0` dianggap "kosong", sehingga sistem menolak menyimpannya!
- Lebih ngerinya lagi, jika sistem dipaksa menyimpan ke `user_id = 0`, maka *semua* anggota yang belum punya akun login akan berbagi saldo simpanan yang sama persis di Dashboard Manager!
- **Tindakan Penyelamatan:** Saya harus merombak *database* secara fundamental (mengubah kolom `user_id` menjadi `anggota_id`) dan menyetel ulang semua logika API agar mereka berpatokan pada ID Anggota asli. Berkat temuan ini, sistem kini kebal dari cacat data dan jauh lebih fleksibel untuk ke depannya.

Begitulah cara sebuah elemen yang tadinya mati bisa disulap menjadi fitur yang cerdas, responsif, dan memanjakan mata pengguna, sambil memastikan pondasinya sangat kokoh di belakang layar.
