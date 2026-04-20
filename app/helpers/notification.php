<?php

/**
 * Helper Notifikasi (Database Driven - Facebook Style)
 */

function sendNotifikasi($userId, $tipe, $icon, $judul, $pesan, $link) {
    if (!$userId) return;
    try {
        $db = db();
        
        // FIFO: Hapus jika sudah ada 5 (sebelum insert yang baru)
        // Kita hitung dulu ada berapa untuk user ini
        $stmtCount = $db->prepare("SELECT COUNT(*) as jml FROM notifikasi WHERE user_id = ?");
        $stmtCount->execute([$userId]);
        $count = $stmtCount->fetch()['jml'] ?? 0;

        if ($count >= 5) {
            // Hapus yang paling lama (ID terkecil)
            $db->prepare("DELETE FROM notifikasi WHERE user_id = ? ORDER BY id ASC LIMIT 1")->execute([$userId]);
        }

        $stmt = $db->prepare("INSERT INTO notifikasi (user_id, tipe, icon, judul, pesan, link) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $tipe, $icon, $judul, $pesan, $link]);
    } catch (Exception $e) {
        error_log("Gagal mengirim notifikasi: " . $e->getMessage());
    }
}

function notifyRole($roles, $tipe, $icon, $judul, $pesan, $link) {
    try {
        $db = db();
        if (!is_array($roles)) $roles = [$roles];
        if (empty($roles)) return;
        
        $placeholders = implode(',', array_fill(0, count($roles), '?'));
        $stmt = $db->prepare("SELECT id FROM users WHERE role IN ($placeholders)");
        $stmt->execute($roles);
        $users = $stmt->fetchAll();
        
        foreach ($users as $user) {
            sendNotifikasi($user['id'], $tipe, $icon, $judul, $pesan, $link);
        }
    } catch (Exception $e) {
        error_log("Gagal mengirim notifikasi ke role: " . $e->getMessage());
    }
}

function getPendingNotifications() {
    try {
        $userId = Auth::id();
        if (!$userId) return ['count' => 0, 'items' => []];

        $db = db();
        
        // Count unread
        $stmt = $db->prepare("SELECT COUNT(*) as jml FROM notifikasi WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        $count = $stmt->fetch()['jml'] ?? 0;
        
        // Get limits records
        $stmt = $db->prepare("SELECT * FROM notifikasi WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$userId]);
        $items = $stmt->fetchAll();
        
        return [
            'count' => $count,
            'items' => $items
        ];
    } catch (Exception $e) {
        return ['count' => 0, 'items' => []];
    }
}
