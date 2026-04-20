<?php
/**
 * ProfileController
 * Handle user profile display
 */

require_once APP_PATH . '/models/Anggota.php';
require_once APP_PATH . '/models/User.php';

class ProfileController extends Controller
{
    private $userModel;
    private $anggotaModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->anggotaModel = new Anggota();
    }

    public function index()
    {
        Auth::requireLogin();

        $userId = Auth::id();
        $user = $this->userModel->find($userId);

        $anggota = null;
        if ($user['role'] === ROLE_ANGGOTA) {
            $anggota = $this->anggotaModel->findWhere(['user_id' => $userId]);
        }

        $this->view('profile/index', [
            'pageTitle' => 'Profil Pengguna',
            'user' => $user,
            'anggota' => $anggota
        ]);
    }
}
