<?php
/**
 * AuthController
 * Handle authentication (login, logout)
 */

require_once APP_PATH . '/models/User.php';

class AuthController extends Controller
{

    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function loginForm()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            $role = Auth::role();

            // Redirect based on role
            switch ($role) {
                case ROLE_ADMIN:
                    $this->redirect('/validator');
                    break;
                case ROLE_TELLER:
                    $this->redirect('/bau');
                    break;
                case ROLE_KETUA:
                    $this->redirect('/manager');
                    break;
                case ROLE_ANGGOTA:
                    $this->redirect('/anggota/dashboard');
                    break;
                default:
                    $this->redirect('/dashboard');
            }
        }

        $this->view('auth/login', [], false);
    }

    /**
     * Process login
     */
    public function login()
    {
        if (!$this->isPost()) {
            $this->redirect('/login');
        }

        // Get input
        $username = clean($this->post('username'));
        $password = $this->post('password');
        $remember = $this->post('remember');

        // Validation
        $errors = $this->validate([
            'username' => $username,
            'password' => $password
        ], [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!empty($errors)) {
            View::setErrors($errors);
            View::setOld(['username' => $username]);
            $this->redirect('/login', 'Silakan lengkapi form login', 'error');
        }

        // Attempt login
        if (Auth::attempt($username, $password)) {
            // Log audit
            $this->logAudit('LOGIN', 'users', Auth::id(), 'User logged in successfully');

            // Detect if password is same as username
            if ($password === $username) {
                $_SESSION['must_change_password'] = true;
            } else {
                unset($_SESSION['must_change_password']);
            }

            // Redirect based on role
            $role = Auth::role();
            if (isset($_SESSION['must_change_password']) && $_SESSION['must_change_password'] === true) {
                $this->redirect('/force-password', 'Demi keamanan, silakan ganti password default Anda.', 'warning');
            }

            switch ($role) {
                case ROLE_ADMIN:
                    $this->redirect('/validator');
                    break;
                case ROLE_TELLER:
                    $this->redirect('/bau');
                    break;
                case ROLE_KETUA:
                    $this->redirect('/manager');
                    break;
                case ROLE_ANGGOTA:
                    $this->redirect('/anggota/dashboard');
                    break;
                default:
                    $this->redirect('/dashboard');
            }
        } else {
            // Log failed attempt
            $this->logFailedLogin($username);

            View::setOld(['username' => $username]);
            $this->redirect('/login', 'Username atau password salah', 'error');
        }
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        Auth::requireLogin();
        
        // Fetch fresh user data
        $db = db();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([Auth::id()]);
        $user = $stmt->fetch();

        // Fetch koperasi settings (for Manager only)
        $settings = null;
        if (Auth::role() === ROLE_KETUA) {
            $settings = $db->query("SELECT * FROM setting_koperasi ORDER BY id DESC LIMIT 1")->fetch();
        }

        $this->view('auth/settings', [
            'pageTitle' => 'Pengaturan',
            'user' => $user,
            'settings' => $settings
        ]);
    }

    /**
     * Process change password
     */
    public function updatePassword()
    {
        Auth::requireLogin();

        if (!$this->isPost()) {
            $this->redirect('/settings');
        }

        $oldPassword = $this->post('old_password');
        $newPassword = $this->post('new_password');
        $confirmPassword = $this->post('confirm_password');

        // Validation
        $errors = $this->validate([
            'old_password' => $oldPassword,
            'new_password' => $newPassword,
            'confirm_password' => $confirmPassword
        ], [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required'
        ]);

        if ($newPassword !== $confirmPassword) {
            $errors['confirm_password'] = 'Konfirmasi password tidak cocok';
        }

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->redirect('/settings', 'Silakan perbaiki kesalahan berikut', 'error');
        }

        // Verify old password
        $db = db();
        $stmt = $db->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([Auth::id()]);
        $user = $stmt->fetch();

        if (!Auth::verifyPassword($oldPassword, $user['password_hash'])) {
            View::setErrors(['old_password' => 'Password lama tidak sesuai']);
            $this->redirect('/settings', 'Password lama tidak sesuai', 'error');
        }

        // Update password
        $newHash = Auth::hashPassword($newPassword);
        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$newHash, Auth::id()]);

        // Remove session flag
        unset($_SESSION['must_change_password']);

        // Audit log
        $this->logAudit('CHANGE_PASSWORD', 'users', Auth::id(), 'User changed password successfully');

        $this->redirect('/settings', 'Password berhasil diubah!', 'success');
    }

    /**
     * Show force change password form
     */
    public function showForcePassword()
    {
        Auth::requireLogin();
        
        // Ensure user actually needs to be here
        if (!isset($_SESSION['must_change_password']) || $_SESSION['must_change_password'] !== true) {
            $this->redirect('/');
        }

        $this->view('auth/force_password', [
            'pageTitle' => 'Keamanan Akun'
        ], false); // No layout, we want full page
    }

    /**
     * Process force change password
     */
    public function updateForcePassword()
    {
        Auth::requireLogin();
        
        if (!$this->isPost()) {
            $this->redirect('/force-password');
        }

        $newPassword = $this->post('new_password');
        $confirmPassword = $this->post('confirm_password');

        // Validation rules
        $errors = [];
        
        if (empty($newPassword)) {
            $errors['new_password'] = 'Password baru wajib diisi';
        } elseif (strlen($newPassword) < 6) {
            $errors['new_password'] = 'Password minimal 6 karakter';
        } elseif (!preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
            $errors['new_password'] = 'Password harus mengandung huruf besar, huruf kecil, dan angka';
        }

        if ($newPassword !== $confirmPassword) {
            $errors['confirm_password'] = 'Konfirmasi password tidak cocok';
        }

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->view('auth/force_password', [
                'pageTitle' => 'Keamanan Akun',
                'errors' => $errors
            ], false);
            return;
        }

        // Update password
        $db = db();
        $newHash = Auth::hashPassword($newPassword);
        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$newHash, Auth::id()]);

        // Clear flag
        unset($_SESSION['must_change_password']);

        // Log audit
        $this->logAudit('FORCE_CHANGE_PASSWORD', 'users', Auth::id(), 'User performed mandatory password reset');

        // Redirect to dashboard based on role
        $role = Auth::role();
        $target = '/dashboard';
        if ($role === ROLE_ADMIN) $target = '/validator';
        elseif ($role === ROLE_KETUA) $target = '/manager';
        elseif ($role === ROLE_TELLER) $target = '/bau';
        elseif ($role === ROLE_ANGGOTA) $target = '/anggota/dashboard';

        $this->redirect($target, 'Password berhasil diperbarui! Selamat datang.', 'success');
    }

    /**
     * Process update interest rates (Manager/Admin only)
     */
    public function updateInterestRates()
    {
        Auth::requireLogin();
        if (Auth::role() !== ROLE_KETUA) {
            $this->redirect('/settings', 'Akses ditolak', 'error');
        }

        if (!$this->isPost()) {
            $this->redirect('/settings');
        }

        $bungaPendek = $this->post('bunga_jangka_pendek');
        $bungaPanjang = $this->post('bunga_jangka_panjang');

        // Validation
        $errors = $this->validate([
            'bunga_jangka_pendek' => $bungaPendek,
            'bunga_jangka_panjang' => $bungaPanjang
        ], [
            'bunga_jangka_pendek' => 'required|numeric',
            'bunga_jangka_panjang' => 'required|numeric'
        ]);

        if (!empty($errors)) {
            View::setErrors($errors);
            $this->redirect('/settings#interest', 'Silakan perbaiki kesalahan berikut', 'error');
        }

        try {
            $db = db();
            // We update the latest record or create one if not exists
            $stmt = $db->prepare("
                UPDATE setting_koperasi 
                SET bunga_jangka_pendek = ?, bunga_jangka_panjang = ?
                ORDER BY id DESC LIMIT 1
            ");
            $stmt->execute([$bungaPendek, $bungaPanjang]);

            // Audit log
            $this->logAudit('UPDATE_INTEREST_RATES', 'setting_koperasi', 1, "Bunga updated: Pendek=$bungaPendek%, Panjang=$bungaPanjang%");

            $this->redirect('/settings#interest', 'Suku bunga berhasil diperbarui!', 'success');
        } catch (Exception $e) {
            $this->redirect('/settings#interest', 'Gagal memperbarui suku bunga: ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Process update member savings configuration (Validator only)
     */
    public function updateSavings()
    {
        Auth::requireLogin();
        if (Auth::role() !== ROLE_ADMIN) {
            $this->redirect('/settings', 'Akses ditolak', 'error');
        }

        if (!$this->isPost()) {
            $this->redirect('/settings');
        }

        $anggotaId = $this->post('user_id'); // From hidden input
        $motor = $this->post('simpanan_motor');
        $mobil = $this->post('simpanan_mobil');

        // Jika input kosong, set ke 0
        $motor = ($motor === '' || $motor === null) ? 0 : $motor;
        $mobil = ($mobil === '' || $mobil === null) ? 0 : $mobil;

        if (!$anggotaId) {
            $this->redirect('/settings#savings-config', 'Pilih anggota terlebih dahulu', 'error');
        }

        // Allow 0 values, but validate they are numeric
        if (!is_numeric($motor) || !is_numeric($mobil)) {
            $this->redirect('/settings#savings-config', 'Nominal harus berupa angka!', 'error');
        }

        try {
            $db = db();
            // Check if exists
            $stmt = $db->prepare("SELECT id FROM konfigurasi_simpanan_anggota WHERE anggota_id = ?");
            $stmt->execute([$anggotaId]);
            $exists = $stmt->fetch();

            if ($exists) {
                $stmt = $db->prepare("
                    UPDATE konfigurasi_simpanan_anggota 
                    SET simpanan_motor = ?, simpanan_mobil = ?
                    WHERE anggota_id = ?
                ");
                $stmt->execute([$motor, $mobil, $anggotaId]);
            } else {
                $stmt = $db->prepare("
                    INSERT INTO konfigurasi_simpanan_anggota (anggota_id, simpanan_motor, simpanan_mobil)
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([$anggotaId, $motor, $mobil]);
            }

            // Get member name for the message
            $stmt = $db->prepare("SELECT nama FROM anggota WHERE id = ?");
            $stmt->execute([$anggotaId]);
            $member = $stmt->fetch();
            $namaAnggota = $member['nama'] ?? 'Anggota';

            // Store data for popup
            $_SESSION['savings_update_success'] = [
                'nama' => $namaAnggota,
                'motor' => $motor,
                'mobil' => $mobil
            ];

            // Audit log
            $this->logAudit('UPDATE_SAVINGS_CONFIG', 'anggota', $anggotaId, "Simpanan updated: Motor=$motor, Mobil=$mobil");

            $this->redirect('/settings#savings-config', 'Konfigurasi simpanan berhasil!', 'success');
        } catch (Exception $e) {
            $this->redirect('/settings#savings-config', 'Gagal memperbarui konfigurasi: ' . $e->getMessage(), 'error');
        }
    }

    /**
     * API: Get member savings configuration
     */
    public function getSavingsConfig()
    {
        Auth::requireLogin();
        $anggotaId = $_GET['user_id'] ?? null;

        if (!$anggotaId) {
            return $this->json(['success' => false, 'message' => 'Anggota ID required'], 400);
        }

        $db = db();
        $stmt = $db->prepare("SELECT simpanan_motor, simpanan_mobil FROM konfigurasi_simpanan_anggota WHERE anggota_id = ?");
        $stmt->execute([$anggotaId]);
        $config = $stmt->fetch();

        return $this->json($config ?: ['simpanan_motor' => 0, 'simpanan_mobil' => 0]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $userId = Auth::id();
        $userName = Auth::user()['name'] ?? 'Unknown';

        // Log audit before logout
        $this->logAudit('LOGOUT', 'users', $userId, "User {$userName} logged out");

        Auth::logout();

        $this->redirect('/login', 'Anda telah logout', 'info');
    }

    /**
     * Log audit trail
     */
    private function logAudit($action, $object, $objectId, $detail)
    {
        try {
            $db = db();
            $stmt = $db->prepare("
                INSERT INTO audit_logs (user_id, aksi, objek, objek_id, detail, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                Auth::id(),
                $action,
                $object,
                $objectId,
                $detail,
                $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
            ]);
        } catch (Exception $e) {
            // Silent fail for audit log
            error_log("Audit log failed: " . $e->getMessage());
        }
    }

    /**
     * Log failed login attempt
     */
    private function logFailedLogin($username)
    {
        try {
            $db = db();
            $stmt = $db->prepare("
                INSERT INTO audit_logs (user_id, aksi, objek, detail, ip_address, user_agent) 
                VALUES (NULL, 'FAILED_LOGIN', 'users', ?, ?, ?)
            ");

            $detail = "Failed login attempt for username: {$username}";

            $stmt->execute([
                $detail,
                $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
            ]);
        } catch (Exception $e) {
            error_log("Failed login log error: " . $e->getMessage());
        }
    }
}