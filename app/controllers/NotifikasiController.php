<?php
/**
 * NotifikasiController
 * Mengelola aksi AJAX untuk fitur Lonceng
 */

class NotifikasiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::requireLogin();
    }

    /**
     * Set semua notifikasi user menjadi 'Telah Dibaca' (is_read = 1)
     */
    public function markAllAsRead()
    {
        // Hanya menerima request tipe POST / AJAX
        if (!$this->isPost()) {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
            return;
        }

        try {
            $userId = Auth::id();
            $db = db();
            $stmt = $db->prepare("UPDATE notifikasi SET is_read = 1 WHERE user_id = ? AND is_read = 0");
            $stmt->execute([$userId]);
            
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
