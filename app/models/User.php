<?php
/**
 * User Model
 * Handle user data operations
 */

class User extends Model {
    
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    /**
     * Find user by username or email
     */
    public function findByUsername($username) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE (username = ? OR email = ?) 
            AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$username, $username]);
        return $stmt->fetch();
    }
    
    /**
     * Find user by email
     */
    public function findByEmail($email) {
        return $this->findWhere(['email' => $email, 'is_active' => 1]);
    }
    
    /**
     * Get all active users
     */
    public function getActiveUsers($role = null) {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
        $params = [];
        
        if ($role) {
            $sql .= " AND role = ?";
            $params[] = $role;
        }
        
        $sql .= " ORDER BY name ASC";
        
        return $this->query($sql, $params);
    }
    
    /**
     * Create new user
     */
    public function createUser($data) {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password_hash'] = Auth::hashPassword($data['password']);
            unset($data['password']);
        }
        
        return $this->insert($data);
    }
    
    /**
     * Update user
     */
    public function updateUser($id, $data) {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password_hash'] = Auth::hashPassword($data['password']);
            unset($data['password']);
        } else {
            unset($data['password']);
            unset($data['password_hash']);
        }
        
        return $this->update($id, $data);
    }
    
    /**
     * Change user status
     */
    public function changeStatus($id, $isActive) {
        return $this->update($id, ['is_active' => $isActive ? 1 : 0]);
    }
    
    /**
     * Update last login
     */
    public function updateLastLogin($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET last_login_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Check if username exists
     */
    public function usernameExists($username, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE username = ?";
        $params = [$username];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->queryOne($sql, $params);
        return $result['count'] > 0;
    }
    
    /**
     * Check if email exists
     */
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->queryOne($sql, $params);
        return $result['count'] > 0;
    }
    
    /**
     * Get users by role
     */
    public function getUsersByRole($role) {
        return $this->where(['role' => $role, 'is_active' => 1], 'name ASC');
    }
    
    /**
     * Get user statistics
     */
    public function getStatistics() {
        $sql = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive,
                SUM(CASE WHEN role = 'ADMIN' THEN 1 ELSE 0 END) as admin,
                SUM(CASE WHEN role = 'TELLER' THEN 1 ELSE 0 END) as teller,
                SUM(CASE WHEN role = 'KETUA' THEN 1 ELSE 0 END) as ketua,
                SUM(CASE WHEN role = 'ANGGOTA' THEN 1 ELSE 0 END) as anggota
            FROM {$this->table}
        ";
        
        return $this->queryOne($sql);
    }
}