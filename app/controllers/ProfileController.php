<?php
/**
 * ProfileController
 * Handle user profile display and updates
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

    // ==========================================
    // FUNGSI UPDATE PROFIL & GAJI (Baru Ditambahkan)
    // ==========================================
    public function update()
    {
        Auth::requireLogin();
        
        // Cek apakah request berupa POST
        if (!$this->isPost()) {
            $this->redirect('/profile');
        }

        // Cek apakah user adalah anggota
        if (Auth::role() === ROLE_ANGGOTA) {
            $data = $this->post();
            $db = db();
            
            try {
                // Update tabel anggota berdasarkan user_id
                $stmt = $db->prepare("UPDATE anggota SET gaji = ?, no_hp = ?, alamat = ? WHERE user_id = ?");
                $stmt->execute([
                    $data['gaji'], 
                    $data['no_hp'], 
                    $data['alamat'], 
                    Auth::id()
                ]);

                $this->redirect('/profile', 'Profil dan Gaji berhasil diperbarui!', 'success');
            } catch (Exception $e) {
                $this->redirect('/profile', 'Gagal menyimpan profil: ' . $e->getMessage(), 'error');
            }
        } else {
            $this->redirect('/profile', 'Hanya anggota yang bisa mengedit profil ini.', 'error');
        }
    }
}