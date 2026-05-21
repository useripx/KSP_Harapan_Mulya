<?php
/**
 * GoogleDriveService
 * Mengintegrasikan sistem koperasi dengan Google Drive via Google Apps Script Web App Proxy
 */

class GoogleDriveService {
    private $webAppUrl;
    private $apiKey;

    public function __construct() {
        $configPath = ROOT_PATH . '/storage/app/google-apps-script-config.json';
        if (!file_exists($configPath)) {
            throw new Exception("Berkas konfigurasi Google Apps Script ('google-apps-script-config.json') tidak ditemukan di direktori storage/app/. Harap buat berkas tersebut terlebih dahulu.");
        }

        $config = json_decode(file_get_contents($configPath), true);
        if (empty($config['web_app_url'])) {
            throw new Exception("URL Web App Google Apps Script belum dikonfigurasi di google-apps-script-config.json. Harap ikuti panduan untuk melakukan deploy Google Apps Script dan masukkan URL-nya.");
        }

        $this->webAppUrl = $config['web_app_url'];
        $this->apiKey = isset($config['api_key']) ? $config['api_key'] : '';
    }

    /**
     * Melakukan request cURL ke Google Apps Script Web App
     */
    private function sendRequest($params) {
        $params['key'] = $this->apiKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->webAppUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Sangat penting karena Google Apps Script melakukan redirect 302
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Waktu habis yang cukup untuk unggahan berkas

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $errorMsg = curl_error($ch);
            curl_close($ch);
            throw new Exception("Koneksi gagal (cURL Error): " . $errorMsg);
        }
        
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("Respons server Google Apps Script tidak valid (HTTP " . $httpCode . "). Pastikan Web App di-deploy dengan opsi 'Anyone' dapat mengakses.");
        }

        $result = json_decode($response, true);
        if (!$result) {
            throw new Exception("Gagal mendekode respons JSON dari Google Apps Script: " . $response);
        }

        if (isset($result['success']) && $result['success'] === false) {
            throw new Exception("Error dari Google Apps Script: " . (isset($result['error']) ? $result['error'] : 'Unknown error'));
        }

        return $result;
    }

    /**
     * Mendapatkan ID folder jika sudah ada, atau membuat folder baru jika belum ada
     * 
     * @param string $folderName Nama folder
     * @param string|null $parentFolderId ID folder induk (opsional)
     * @return string ID folder di Google Drive
     */
    public function getOrCreateFolder($folderName, $parentFolderId = null) {
        $params = [
            'action' => 'getOrCreateFolder',
            'folderName' => $folderName
        ];
        if ($parentFolderId) {
            $params['parentFolderId'] = $parentFolderId;
        }

        $result = $this->sendRequest($params);
        return $result['id'];
    }

    /**
     * Mengunggah berkas lokal ke Google Drive pada folder tertentu
     * 
     * @param string $filePath Path berkas fisik di server lokal
     * @param string $fileName Nama berkas yang diinginkan di Google Drive
     * @param string $parentFolderId ID folder tujuan di Google Drive
     * @return string ID berkas yang berhasil diunggah di Google Drive
     */
    public function uploadFile($filePath, $fileName, $parentFolderId) {
        if (!file_exists($filePath)) {
            throw new Exception("Berkas lokal tidak ditemukan di: " . $filePath);
        }

        $content = file_get_contents($filePath);
        $base64Data = base64_encode($content);

        $params = [
            'action' => 'uploadFile',
            'fileName' => $fileName,
            'parentFolderId' => $parentFolderId,
            'mimeType' => 'application/pdf',
            'data' => $base64Data
        ];

        $result = $this->sendRequest($params);
        return $result['id'];
    }

    /**
     * Menghapus berkas dari Google Drive berdasarkan ID berkas
     * 
     * @param string $driveFileId ID berkas di Google Drive
     * @return bool
     */
    public function deleteFile($driveFileId) {
        try {
            $params = [
                'action' => 'deleteFile',
                'driveFileId' => $driveFileId
            ];
            $this->sendRequest($params);
            return true;
        } catch (Exception $e) {
            error_log("Gagal menghapus berkas di Google Drive ID {$driveFileId}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Memindahkan berkas di Google Drive ke folder KSP_Trash/archiveFolderName/subFolder
     * 
     * @param string $driveFileId ID berkas di Google Drive
     * @param string $archiveFolderName Nama folder arsip tujuan
     * @param string $subFolder Subfolder ('profil' atau 'pinjaman')
     * @return bool
     */
    public function archiveFile($driveFileId, $archiveFolderName, $subFolder) {
        try {
            $params = [
                'action' => 'archiveFile',
                'driveFileId' => $driveFileId,
                'archiveFolderName' => $archiveFolderName,
                'subFolder' => $subFolder
            ];
            $this->sendRequest($params);
            return true;
        } catch (Exception $e) {
            error_log("Gagal mengarsipkan berkas di Google Drive ID {$driveFileId} ke KSP_Trash/{$archiveFolderName}/{$subFolder}: " . $e->getMessage());
            return false;
        }
    }
}
