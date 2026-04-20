<?php
/**
 * AuthMiddleware
 * Memastikan pengguna sudah login sebelum mengakses halaman tertentu.
 */

class AuthMiddleware
{
    public static function handle()
    {
        if (!Auth::check()) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . url('/login'));
            exit;
        }
        return true;
    }
}
