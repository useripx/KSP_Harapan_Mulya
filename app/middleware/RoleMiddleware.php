<?php
/**
 * RoleMiddleware
 * Memastikan pengguna memiliki role yang sesuai untuk mengakses halaman.
 */

class RoleMiddleware
{
    public static function handle($roles)
    {
        if (!Auth::check()) {
            header('Location: ' . url('/login'));
            exit;
        }

        $userRole = Auth::role();
        $allowedRoles = is_array($roles) ? $roles : explode('|', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            $_SESSION['flash_message'] = "Anda tidak memiliki akses ke halaman tersebut.";
            $_SESSION['flash_type'] = "error";
            header('Location: ' . url('/dashboard'));
            exit;
        }

        return true;
    }
}
