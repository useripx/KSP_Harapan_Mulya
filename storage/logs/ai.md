Fitur AI Chatbot pada proyek Anda melibatkan beberapa file yang bekerja sama dari sisi *frontend* hingga *backend*. Berikut adalah penjelasan lengkap mengenai file-file tersebut dan perannya:

### 1. `app/services/GroqService.php` (Core Logic)
Ini adalah "otak" di balik koneksi AI.
*   **Peran**: Menangani komunikasi langsung dengan API Groq (menggunakan model Llama 3).
*   **Fungsi Utama**:
    *   Menerima pesan dari pengguna dan riwayat percakapan.
    *   Menyusun *System Prompt* (instruksi identitas "Anna" sebagai asisten KSP).
    *   Melakukan permintaan HTTP menggunakan `cURL` ke server Groq.
    *   **Baru diperbarui**: Sekarang menangani error koneksi (internet putus) dan pembatasan kuota (*Rate Limit*) dengan pesan yang lebih ramah.

### 2. `app/controllers/ChatbotController.php` (Controller)
Ini adalah perantara (jembatan) antara web dan *service*.
*   **Peran**: Menerima permintaan dari browser, memvalidasinya, dan memanggil `GroqService`.
*   **Fungsi Utama**:
    *   Memeriksa apakah data yang dikirim lengkap (pesan tidak kosong).
    *   Mencatat log debug ke `ai_debug.log` untuk setiap permintaan masuk.
    *   **Baru diperbarui**: Mendeteksi jika `GroqService` mengembalikan pesan error, lalu mengirimkannya kembali ke browser dengan status yang sesuai sehingga frontend tahu itu adalah kesalahan.

### 3. `public/js/chatbot.js` (Frontend logic)
Ini adalah file yang mengontrol tampilan dan interaksi pengguna di browser.
*   **Peran**: Menangani UI chat, animasi, dan pengiriman data secara *background* (AJAX).
*   **Fungsi Utama**:
    *   `toggleChatbot()`: Membuka/menutup jendela chat.
    *   `sendMessage()`: Mengambil teks dari input dan mengirimkannya ke server menggunakan `fetch()`.
    *   `addMessageToUI()`: Menampilkan balon teks pesan pengguna maupun bot di layar.
    *   **Baru diperbarui**: Sekarang memiliki kemampuan untuk mendeteksi pesan error dan menampilkannya dengan **warna merah serta ikon peringatan**.

### 4. `app/config/app.php` (Configuration)
*   **Peran**: Mengatur konfigurasi global aplikasi.
*   **Fungsi Utama**:
    *   Memuat file `.env` ke dalam sistem PHP.
    *   Menyimpan konfigurasi `groq_api_key` sehingga bisa digunakan oleh `GroqService` melalui variabel `$GLOBALS['config']`.

### 5. `public/index.php` (Routing Entry Point)
*   **Peran**: Gerbang utama semua permintaan masuk ke aplikasi.
*   **Fungsi Utama**:
    *   Mendaftarkan *route* `/chatbot/ask` dan menghubungkannya ke `ChatbotController@ask`. Tanpa ini, browser tidak akan tahu ke mana harus mengirimkan pesan chat.

### 6. `.env` (Environment Variables)
*   **Peran**: Tempat penyimpanan data sensitif.
*   **Fungsi Utama**:
    *   Menyimpan `GROQ_API_KEY` milik Anda. File ini tidak boleh dibagikan secara bebas karena merupakan kunci akses ke layanan berbayar/terbatas Groq.

### 7. `storage/logs/ai_debug.log` (Logging)
*   **Peran**: Tempat mencatat riwayat aktivitas AI.
*   **Fungsi Utama**:
    *   Mencatat setiap pesan yang masuk, data yang dikirim ke Groq, serta respons mentah dari server. Jika bot tidak jalan, file inilah tempat pertama yang harus diperiksa untuk mencari penyebabnya.

Secara singkat, alurnya adalah:
**Browser (`chatbot.js`)** ➔ **Server (`index.php`)** ➔ **Controller (`ChatbotController.php`)** ➔ **Service (`GroqService.php`)** ➔ **Cloud AI (Groq API)**.