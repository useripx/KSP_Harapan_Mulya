# LAPORAN PRAKTIK KERJA LAPANGAN (PKL)
**KSP HARAPAN MULYA**

Disusun oleh:
**Yogi Ario Pratama**
**NPM: 2313020004**

---

# BAB I
# PENDAHULUAN

## A. LATAR BELAKANG
Perkembangan teknologi informasi yang begitu pesat telah membawa perubahan besar dalam berbagai aspek kehidupan, termasuk dunia perbankan dan koperasi. Sebagai entitas yang mengelola keuangan dan data anggota yang krusial, koperasi dituntut untuk memiliki sistem informasi yang handal, efisien, dan aman. Koperasi Simpan Pinjam (KSP) Harapan Mulya menyadari pentingnya digitalisasi dalam operasional sehari-hari, terutama dalam pengelolaan data keanggotaan dan penyimpanan dokumen pendukung seperti KTP dan Kartu Keluarga (KK).

Sebagai mahasiswa program studi terkait, tantangan untuk terus mengikuti perkembangan teknologi menjadi semakin besar. Pendidikan di bangku kuliah memang memberikan dasar-dasar keilmuan yang kuat, namun untuk benar-benar siap menghadapi dunia kerja, mahasiswa perlu mendapatkan pengalaman praktis yang relevan. Praktik Kerja Lapangan (PKL) menjadi jembatan antara dunia akademis dan dunia industri, memberikan kesempatan berharga untuk terlibat langsung dalam proyek teknologi nyata.

Fakta di lapangan menunjukkan bahwa pengembangan sistem, khususnya penyimpanan berkas digital (*cloud storage*), sering kali menemui kendala teknis dan biaya. Penggunaan server lokal untuk menyimpan dokumen akan membebani kapasitas *hosting* dan memperlambat performa sistem. Oleh karena itu, dalam pelaksanaan PKL di KSP Harapan Mulya ini, penulis mengambil peran sebagai **Manager (Backend Developer)** yang bertanggung jawab penuh dalam merancang arsitektur sistem informasi berbasis web, dengan fokus utama pada integrasi penyimpanan dokumen ke Google Drive. Melalui PKL ini, diharapkan tercipta sebuah ekosistem data terpadu yang dapat mengatasi batasan kuota penyimpanan konvensional tanpa membebani biaya operasional koperasi.

## B. TUJUAN PRAKTIK KERJA LAPANGAN
Tujuan dari pelaksanaan Praktik Kerja Lapangan (PKL) ini adalah:
1. Memberikan kesempatan kepada mahasiswa untuk melihat secara langsung bagaimana teori pemrograman web (seperti arsitektur MVC, integrasi API, dan manajemen basis data) diterapkan dalam membangun sistem kelas korporat (koperasi).
2. Membangun dan mengimplementasikan sistem penyimpanan *cloud* menggunakan Google Apps Script Web App Proxy untuk KSP Harapan Mulya guna menembus batasan kuota 0 Byte dari Google Service Account.
3. Menjadi sarana evaluasi dan pengembangan kompetensi teknis (membangun *backend* yang ringan tanpa *library* SDK yang memberatkan) serta kompetensi manajerial dalam menyusun *timeline* dan memecahkan masalah (*problem solving*).

## C. MANFAAT PRAKTIK KERJA LAPANGAN
1. **Bagi Mahasiswa**
   a. Mengaplikasikan dan meningkatkan ilmu pemrograman *backend* (PHP Native, cURL, REST API) yang diperoleh di bangku perkuliahan.
   b. Menambah wawasan nyata terkait arsitektur sistem informasi, manajemen *database*, dan *deployment* ke *server live* (cPanel).
   c. Memperoleh portofolio proyek riil berupa Sistem Informasi KSP Harapan Mulya yang terintegrasi penuh dengan *cloud storage*.
2. **Bagi Perguruan Tinggi**
   a. Universitas dapat meningkatkan kualitas lulusannya melalui pengalaman praktik kerja lapangan yang menghasilkan produk teknologi aplikatif.
   b. Terjalinnya kerja sama bilateral yang baik antara universitas dengan instansi/koperasi.
3. **Bagi Instansi (KSP Harapan Mulya)**
   a. Mendapatkan sistem informasi manajemen keanggotaan dan simpan pinjam yang modern, terstruktur, dan siap pakai.
   b. Memiliki infrastruktur penyimpanan berkas digital (dokumen anggota) yang gratis (kuota 15 GB), aman, terhindar dari *bug multi-login*, dan tidak membebani kapasitas memori *hosting* Koperasi.
   c. Meningkatkan efektivitas, kecepatan kerja, dan akurasi data dalam melayani anggota Koperasi.

---

# BAB II
# TEMUAN DATA

## A. LAYANAN KOPERASI DAN OPERASIONAL
KSP Harapan Mulya merupakan lembaga keuangan yang berfokus pada layanan simpanan dan pinjaman bagi para anggotanya. Dalam memberikan layanannya, KSP Harapan Mulya sangat bergantung pada pengelolaan data yang akurat, termasuk data identitas anggota, catatan transaksi, hingga persetujuan dan suku bunga pinjaman. Validasi data membutuhkan dokumen pendukung fisik atau digital (seperti KTP) yang harus diarsip dengan baik agar mudah diakses kembali saat proses evaluasi atau audit.

## B. PENGELOLAAN DATA DAN SISTEM INFORMASI
Sebelum pengembangan sistem ini, pengelolaan data KSP Harapan Mulya masih menghadapi tantangan dalam hal penyimpanan dokumen digital. Pengunggahan berkas secara langsung ke *server lokal* (*hosting*) dinilai tidak efisien karena akan menghabiskan ruang penyimpanan dan memperlambat akses aplikasi. Oleh karena itu, KSP Harapan Mulya membutuhkan sistem berbasis web terpadu yang dapat menangani:
1. Pendaftaran dan verifikasi keanggotaan secara digital.
2. Pengaturan akses berbasis peran (*Role-Based Access Control* / RBAC) untuk berbagai level pengguna seperti Validator, BAU, dan Manager.
3. Pengaturan suku bunga yang dinamis untuk produk pinjaman.
4. Penyimpanan dokumen persyaratan secara otomatis ke sistem *cloud* pihak ketiga.

## C. SARANA DAN PRASARANA BIDANG TEKNOLOGI
Untuk menunjang kegiatan operasional dan pengembangan sistem ini, KSP Harapan Mulya memanfaatkan beberapa teknologi dan infrastruktur:
1. Komputer/Laptop pengembang menggunakan *local web server* (Laragon/XAMPP) dengan lingkungan PHP 8.x dan basis data MySQL.
2. Sistem *hosting* (cPanel) untuk *deployment server live*.
3. Infrastruktur *cloud* Google Drive sebagai repositori utama dokumen.

## D. PELAYANAN ANGGOTA
Data yang dikelola dan dianalisis dalam sistem KSP Harapan Mulya berdampak langsung pada pelayanan anggota. Akurasi dan kelengkapan dokumen menentukan seberapa cepat proses persetujuan pinjaman dapat dilakukan. Dengan sistem yang baru, ketika *Validator* mengunggah dokumen KTP anggota, sistem dapat menyimpannya ke *cloud* dalam hitungan detik dan menampilkan pratinjau dokumen langsung di dalam aplikasi (melalui *Iframe Viewer*), tanpa perlu mengunduh file secara manual. Hal ini meningkatkan transparansi dan kecepatan pelayanan secara signifikan.

## E. HAMBATAN DAN TANTANGAN
Dalam proses pengelolaan data digital, KSP Harapan Mulya menghadapi rintangan teknis yang cukup berat terkait integrasi Google Drive, di antaranya:
1. **OAuth 2.0 (User Flow):** Menyebabkan kelelahan verifikasi token (*Token Expiry Fatigue*). *Validator* sering terganggu oleh *pop-up* login Google yang kedaluwarsa setiap 1 jam, dan proses unggah latar belakang (*background jobs*) sering gagal.
2. **Google Service Account (Akun Robot):** Menghadapi tembok pembatas kuota modern "0 Byte", di mana Google menghentikan kuota gratis untuk akun robot baru, memicu *error `storageQuotaExceeded`*. Selain itu, instalasi SDK PHP Google sangat berat (mencapai >20MB) yang membebani *server hosting*, serta rentan terhadap *error* "403 Forbidden" jika pengguna membuka *browser* dengan *multi-login* Gmail.

---

# BAB III
# ANALISIS DATA

## A. BIDANG MANAJEMEN ORGANISASI
**1. Peran dan Fungsi KSP Harapan Mulya**
KSP Harapan Mulya berperan krusial dalam mendukung perekonomian anggotanya. Sistem yang dikembangkan dirancang untuk menyederhanakan birokrasi internal koperasi, mempercepat proses kerja staf (seperti *Validator* dan *BAU*), serta memastikan kebijakan (seperti penetapan suku bunga) dapat diterapkan secara dinamis oleh manajemen.

**2. Peran Manajer Pengembang (Backend)**
Dalam PKL ini, penulis berperan sebagai **Manager (Backend)** yang memegang tanggung jawab strategis merancang arsitektur sistem inti. Tanggung jawab ini mencakup pembuatan sistem *routing* (MVC murni), logika basis data (*PDO Singleton*), pengamanan data, manajemen sesi/otorisasi pengguna, dan yang paling utama: memecahkan kebuntuan teknis dalam integrasi penyimpanan awan (Google Drive). Selain itu, penulis juga memastikan integrasi fitur inti seperti suku bunga dinamis dan pembersihan modul yang tidak relevan (seperti *chatbot*) berjalan dengan baik tanpa merusak fitur eksisting.

## B. BIDANG SISTEM INFORMASI
Sistem yang digunakan adalah aplikasi web *custom* dengan arsitektur *Model-View-Controller* (MVC). Salah satu terobosan utama dalam sistem informasi ini adalah solusi integrasi penyimpanan *cloud*. 

**Google Apps Script Web App Proxy sebagai Solusi Terpadu**
Berdasarkan temuan data mengenai hambatan metode OAuth 2.0 dan Service Account, penulis mengimplementasikan arsitektur **Google Apps Script Web App Proxy**. Analisis efektivitas metode ini menunjukkan:
1. **Bypass Kuota 0 Byte:** Dengan menggunakan skrip `doPost(e)` yang dijalankan di akun Gmail koperasi (`koperasiharapanmulyaunp@gmail.com`), file berhasil disimpan menggunakan otoritas akun Gmail tersebut, sehingga sistem mendapatkan kuota 15 GB gratis secara sah.
2. **Performa Ringan (Tanpa SDK):** Sistem tidak lagi membutuhkan pustaka Google Client API PHP yang membebani *server* (>20MB). Aplikasi PHP kini cukup menggunakan `cURL` *Native* bawaan *hosting*, membuat *loading* sistem jauh lebih cepat.
3. **Penanganan Bug 403 (Multi-Akun Google):** Skrip secara otomatis mengatur hak akses dokumen yang diunggah menjadi *"Anyone with link (Viewer)"*, sehingga dokumen dapat dipratinjau secara mulus di halaman *dashboard* KSP tanpa terpengaruh konflik *login* akun Gmail di *browser* staf.
4. **Offline Local Fallback:** Sistem dilengkapi proteksi jaringan. Jika Google Apps Script gagal diakses, file akan otomatis tersimpan di server *local hosting* agar operasional koperasi tidak terhenti.

## C. BIDANG SISTEM DATABASE
Pengelolaan data terpusat menggunakan sistem basis data MySQL relasional. Penulis merancang skema *database* KSP yang mencakup tabel `anggota` untuk menyimpan profil dan tabel `anggota_dokumen` untuk menyimpan ID unik dari Google Drive (`drive_file_id`) beserta nama berkas cadangan lokal. Keterkaitan sistem relasional ini memastikan data profil selalu sinkron dengan berkas fisiknya, di mana pembaruan atau penghapusan berkas di aplikasi akan memicu perintah `cURL` untuk memindahkan berkas fisik di Google Drive ke folder Sampah (*Trash*).

## D. BIDANG JARINGAN KOMPUTER
Meskipun tidak secara langsung membangun infrastruktur fisik jaringan, sistem ini sangat bergantung pada stabilitas koneksi internet. Komunikasi antara aplikasi web KSP (PHP Laragon/cPanel) dengan *server* Google dilakukan melalui metode permintaan HTTP POST (*cURL*). Keamanan dijamin melalui pengiriman data berkas terenkripsi `Base64` dan pemadanan kunci API (`API_KEY`) yang disimpan secara terpisah di file konfigurasi lokal `google-apps-script-config.json` yang diabaikan dari repositori Git publik.

## E. BIDANG PERANGKAT KERAS
Perangkat keras yang digunakan meliputi:
1. Unit Komputer/Laptop pengembang untuk *coding* lokal, *testing*, dan inisialisasi basis data.
2. *Server Hosting* (*Cloud*) yang digunakan untuk mendeploy aplikasi setelah divalidasi kelayakannya di *localhost*.

## F. KEGIATAN PRAKTIK KERJA LAPANGAN
**1. Deskripsi Umum Proyek**
Praktik Kerja Lapangan dilaksanakan melalui pengerjaan proyek sistem informasi terpadu untuk KSP Harapan Mulya, di mana penulis fokus pada pembangunan pondasi aplikasi *Backend* dan integrasi penyimpanan data berskala *enterprise*.

**2. Kegiatan yang Dilakukan selama PKL**
Selama PKL, penulis melakukan berbagai tahapan pengembangan secara terstruktur:
*   **Fase Inisialisasi & Core MVC:** Menyusun *router*, *controller*, dan konfigurasi .env lokal.
*   **Fase Arsitektur Database:** Membuat struktur *database* MySQL dan mengatur koneksi PDO Singleton.
*   **Fase Fitur Utama:** Mengembangkan fitur CRUD Anggota, pengaturan fitur suku bunga dinamis (di `AuthController` dan `settings.php`), standarisasi pengajuan pinjaman, dan pembersihan tuntas kode *chatbot* usang untuk optimasi sistem.
*   **Fase Pemecahan Masalah Cloud:** Melakukan riset komparasi teknologi API Google Drive, menghadapi limitasi akun robot, hingga merumuskan dan membuat skrip *proxy* di Google Apps Script (Web App).
*   **Fase Integrasi Driver PHP:** Menulis `GoogleDriveService.php` berbasis `cURL`, mengintegrasikan FPDF untuk mengonversi gambar ke PDF secara otomatis sebelum diunggah ke awan, serta menyiapkan *fallback* lokal.
*   **Fase Deployment:** Mengunggah sistem dari lingkungan Laragon lokal ke *hosting* cPanel *live*, mengatur `.htaccess`, dan memverifikasi stabilitas pengunggahan *cloud* di produksi.

---

# BAB IV
# PENUTUP

## A. KESIMPULAN
Berdasarkan pelaksanaan Praktik Kerja Lapangan (PKL) yang berfokus pada pengembangan *Backend* Sistem Informasi KSP Harapan Mulya, dapat disimpulkan bahwa:
1. KSP Harapan Mulya kini memiliki infrastruktur perangkat lunak berbasis MVC yang handal, terstruktur, dan siap mendukung kegiatan operasional seperti manajemen anggota, pengajuan pinjaman, dan penetapan suku bunga yang dinamis.
2. Solusi arsitektur integrasi Google Drive menggunakan metode **Google Apps Script Web App Proxy** terbukti sangat efektif. Metode ini berhasil memecahkan kendala limitasi kuota 0 Byte dari *Service Account* sehingga koperasi mendapatkan penyimpanan gratis sebesar 15 GB, menghilangkan beban *library* SDK yang berat, dan mengeliminasi masalah perizinan (Error 403) secara otomatis.
3. Melalui peran sebagai Manajer Backend, PKL ini memberikan gambaran langsung mengenai proses pengambilan keputusan arsitektural (*problem solving*), pembuatan *driver* kustom, dan penerapan keamanan sistem berlapis sebelum aplikasi diluncurkan ke *server live* (cPanel).

## B. SARAN
Untuk meningkatkan efektivitas pengelolaan sistem KSP Harapan Mulya ke depannya, penulis memberikan saran:
1. Perlu dilakukannya pencadangan (*backup*) basis data MySQL secara berkala (otomatis) di *server hosting* untuk menghindari kehilangan rekaman ID Dokumen (Drive ID) yang sangat krusial.
2. Peningkatan kapasitas *server hosting* mungkin diperlukan di masa mendatang jika jumlah akses anggota yang menggunakan layanan secara bersamaan (konkurensi) meningkat drastis.
3. Mempertimbangkan penambahan modul sinkronisasi *cron job* untuk memantau integritas data antara berkas yang tercatat di basis data lokal dengan file aktual yang ada di Google Drive, guna memastikan tidak ada *file* sampah yang tertinggal.
