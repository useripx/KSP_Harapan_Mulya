<?php
/**
 * AuditLog Model
 */

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    /**
     * Create a new log entry
     * 
     * @param string $action Action name (e.g. 'PENGAJUAN_PINJAMAN')
     * @param string $resource Resource type (e.g. 'pinjaman')
     * @param int|null $resourceId ID of the resource
     * @param string|null $description Additional details
     * @return int Insert ID
     */
    public function log($action, $resource, $resourceId = null, $description = null)
    {
        return $this->insert([
            'user_id' => Auth::id(),
            'aksi' => $action,
            'objek' => $resource,
            'objek_id' => $resourceId,
            'detail' => $description,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get logs for a specific resource
     */
    public function getByResource($resource, $resourceId)
    {
        $sql = "SELECT l.*, u.name as user_nama 
                FROM audit_logs l
                LEFT JOIN users u ON l.user_id = u.id
                WHERE l.resource = ? AND l.resource_id = ?
                ORDER BY l.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$resource, $resourceId]);
        return $stmt->fetchAll();
    }
}
