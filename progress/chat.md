Created PRESENTASI_FINAL.md

Untuk membuat atau memodifikasi fitur **Chatbot Anita**, ada 5 file kunci yang bekerja secara terintegrasi. Berikut adalah daftar dan fungsinya:

### 1. Backend (Logika & API)
*   **`app/services/GroqService.php`**  
    Ini adalah "otak" dari AI. Di sini Anda bisa mengubah **System Prompt** (instruksi agar AI berperilaku sebagai asisten koperasi), mengatur model AI (Llama 3/Gemini), dan mengelola API Key.
*   **`app/controllers/ChatbotController.php`**  
    Bertindak sebagai jembatan. File ini menerima pesan dari antarmuka web melalui AJAX, mengirimkannya ke `GroqService`, lalu mengembalikan jawaban dalam format JSON.
*   **`.env`**  
    Berisi variabel lingkungan, terutama `GROQ_API_KEY`. Jika chatbot tidak merespon, pastikan API Key di file ini sudah benar.

### 2. Frontend (Tampilan & Interaksi)
*   **`public/js/chatbot.js`**  
    Mengatur perilaku interaktif di browser. Seperti: animasi mengetik (*typing indicator*), pengiriman pesan saat tombol Enter ditekan, dan menampilkan balasan AI ke dalam balon chat.
*   **`views/layout/chatbot.php`**  
    Berisi struktur HTML (kerangka chat) dan semua gaya visual (CSS). Jika Anda ingin mengubah warna chat, ukuran jendela, atau posisi tombol "Anita", modifikasi file ini di bagian `<style>`.

### 3. Integrasi Halaman
*   **`views/layout/main.php`** atau **`views/layout/footer.php`**  
    File ini biasanya memanggil `include 'chatbot.php'` agar chatbot muncul di seluruh dashboard anggota/admin.
*   **`views/auth/login.php`**  
    Khusus untuk halaman login, chatbot dipanggil secara mandiri agar calon anggota bisa bertanya tanpa perlu masuk ke sistem.

---
> [!TIP]
> Jika Anda ingin mengubah **nama asisten** atau **cara ia menyapa**, cukup buka **`app/services/GroqService.php`** dan cari bagian `$system_instruction`.