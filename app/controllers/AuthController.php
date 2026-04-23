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
            switch ($role) {
                case ROLE_ADMIN:
                    $this->redirect('/validator', 'Selamat datang, Validator!', 'success');
                    break;
                case ROLE_TELLER:
                    $this->redirect('/bau', 'Selamat datang, BAU!', 'success');
                    break;
                case ROLE_KETUA:
                    $this->redirect('/manager', 'Selamat datang, Manager!', 'success');
                    break;
                case ROLE_ANGGOTA:
                    $this->redirect('/anggota/dashboard', 'Selamat datang, Anggota!', 'success');
                    break;
                default:
                    $this->redirect('/dashboard', 'Login berhasil!', 'success');
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

        $this->view('auth/settings', [
            'pageTitle' => 'Pengaturan',
            'user' => $user
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