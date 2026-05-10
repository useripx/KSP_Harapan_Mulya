<?php
/**
 * UserController
 * Handle user management for Admin
 */

require_once APP_PATH . '/models/User.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        Auth::requireRole(ROLE_ADMIN);
        $this->userModel = new User();
    }

    public function index()
    {
        $users = $this->userModel->all('name ASC');
        $stats = $this->userModel->getStatistics();

        $this->view('user/index', [
            'pageTitle' => 'Manajemen User',
            'users' => $users,
            'stats' => $stats
        ]);
    }

    public function create()
    {
        $this->view('user/create', [
            'pageTitle' => 'Tambah User Baru',
            'roles' => [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA]
        ]);
    }

    public function store()
    {
        $data = $this->post();

        $rules = [
            'nama' => 'required',
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required'
        ];

        $errors = $this->validate($data, $rules);

        if ($this->userModel->usernameExists($data['username'])) {
            $errors['username'] = 'Username sudah digunakan';
        }

        if ($this->userModel->emailExists($data['email'])) {
            $errors['email'] = 'Email sudah digunakan';
        }

        if (!empty($errors)) {
            return $this->view('user/create', [
                'pageTitle' => 'Tambah User Baru',
                'errors' => $errors,
                'old' => $data,
                'roles' => [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA]
            ]);
        }

        $userId = $this->userModel->createUser([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'is_active' => isset($data['is_active']) ? 1 : 0
        ]);

        if ($userId) {
            $this->redirect('/users', 'User berhasil ditambahkan', 'success');
        } else {
            $this->redirect('/users/create', 'Gagal menambahkan user', 'error');
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            $this->redirect('/users', 'User tidak ditemukan', 'error');
        }

        $db = db();
        $stmt = $db->prepare("SELECT * FROM anggota WHERE user_id = ?");
        $stmt->execute([$id]);
        $anggota = $stmt->fetch();

        // PERBAIKAN: Jika data anggota tidak ada, buat array default agar view tidak error
        if ($anggota === false) {
            $anggota = [
                'nama' => '', 
                'status_validator' => 0,
                'tipe' => '',
                'identitas_no' => '',
                'prodi_unit' => '',
                'no_hp' => '',
                'alamat' => '',
                'tgl_daftar' => date('Y-m-d'),
                'status' => 'AKTIF'
            ];
        }

        $this->view('user/edit', [
            'pageTitle' => 'Edit User & Anggota',
            'user'      => $user,
            'anggota'   => $anggota, 
            'roles'     => [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA]
        ]);
    }

public function update($id)
{
    $data = $this->post();

    // Validasi dasar
    $rules = [
        'name' => 'required',
        'username' => 'required|min:3',
        'email' => 'required|email',
        'role' => 'required'
    ];

    $errors = $this->validate($data, $rules);

    if (!empty($errors)) {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM anggota WHERE user_id = ?");
        $stmt->execute([$id]);
        $anggota = $stmt->fetch();

        return $this->view('user/edit', [
            'pageTitle' => 'Edit User',
            'user'      => $this->userModel->find($id),
            'anggota'   => $anggota,
            'errors'    => $errors,
            'old'       => $data,
            'roles'     => [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA]
        ]);
    }

    try {
        $db = db();
        $db->beginTransaction();

        // 1. Ambil data user lama (untuk proteksi role)
        $currentUserData = $this->userModel->find($id);
        
        // 2. Tentukan status login (tabel users)
        //$isActive = isset($data['is_active']) ? 1 : 0;

        // 3. LOGIKA SINKRONISASI: Paksa status anggota mengikuti is_active user
        // Pastikan 'NONAKTIF' sesuai dengan ENUM di database Anda
        //$statusUntukAnggota = ($isActive == 1) ? 'AKTIF' : 'NONAKTIF';

        $statusDariForm = $data['status_keanggotaan'] ?? 'AKTIF';

        // 4. Update Tabel Users
        $updateUserData = [
            'name'      => $data['name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            // Jika status NONAKTIF atau KELUAR, otomatis matikan akses login (is_active = 0)
            'is_active' => ($statusDariForm === 'AKTIF') ? 1 : 0, 
            'role'      => ($id == Auth::id()) ? $currentUserData['role'] : $data['role']
        ];

        if (!empty($data['password'])) {
            $updateUserData['password'] = $data['password'];
        }
        
        $this->userModel->updateUser($id, $updateUserData);

        // 5. Update Tabel Anggota (Sinkronisasi Profil & Status)
        $stmt = $db->prepare("UPDATE anggota SET 
            nama = ?,             -- 1
            tipe = ?,             -- 2
            identitas_no = ?,     -- 3
            prodi_unit = ?,       -- 4
            no_hp = ?,            -- 5
            alamat = ?,           -- 6
            tgl_daftar = ?,       -- 7
            status = ?,           -- 8 (String 'AKTIF' atau 'NONAKTIF')
            status_validator = ?  -- 9
            WHERE user_id = ?");  

            $stmt->execute([
                $data['name'],         // 1
                $data['tipe'],         // 2
                $data['identitas_no'], // 3
                $data['prodi_unit'],   // 4
                $data['no_hp'],        // 5
                $data['alamat'],       // 6
                $data['tgl_daftar'],   // 7
                $statusDariForm,       // 8 (Sekarang mengambil nilai dari dropdown form)
                isset($data['status_validator']) ? 1 : 0, // 9
                $id                    // 10
            ]);

        // Cek jika ada error database (misal: nilai ENUM salah)
        if ($stmt->errorCode() !== '00000') {
            $info = $stmt->errorInfo();
            throw new Exception("Database Error: " . $info[2]);
        }

        $db->commit();
        return $this->redirect('/users', 'Data user dan anggota berhasil diperbarui', 'success');

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        return $this->redirect("/users/$id/edit", 'Gagal update: ' . $e->getMessage(), 'error');
    }
}

    public function delete($id)
    {
        try {
            $db = db();
            $db->beginTransaction();

            // 1. Hapus data di tabel anggota terlebih dahulu (karena memiliki relasi user_id)
            $stmtAnggota = $db->prepare("DELETE FROM anggota WHERE user_id = ?");
            $stmtAnggota->execute([$id]);

            // 2. Hapus data di tabel users
            $stmtUser = $db->prepare("DELETE FROM users WHERE id = ?");
            $success = $stmtUser->execute([$id]);

            if ($success) {
                $db->commit();
                return $this->redirect('/users', 'User dan data anggota berhasil dihapus selamanya', 'success');
            } else {
                $db->rollBack();
                return $this->redirect('/users', 'Gagal menghapus user', 'error');
            }

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            return $this->redirect('/users', 'Terjadi kesalahan: ' . $e->getMessage(), 'error');
        }
    }

    public function toggleStatus($id)
    {
        try {
            $db = db();
            $db->beginTransaction();

            // 1. Ambil status user saat ini
            $stmt = $db->prepare("SELECT is_active FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();

            if (!$user) {
                throw new Exception("User tidak ditemukan.");
            }

            // 2. Tentukan status baru (kebalikan dari status saat ini)
            $newStatus = $user['is_active'] ? 0 : 1;

            // --- SOLUSI: Konversi angka ke string ENUM ---
            $statusEnum = $newStatus ? 'AKTIF' : 'NONAKTIF';

            // 3. Update tabel Users (menggunakan angka 0/1)
            $updateUser = $db->prepare("UPDATE users SET is_active = ? WHERE id = ?");
            $updateUser->execute([$newStatus, $id]);

            // 4. Update tabel Anggota (menggunakan string 'AKTIF'/'NONAKTIF')
            // Berdasarkan skema, tabel anggota memiliki kolom 'status' bertipe ENUM
            $updateAnggota = $db->prepare("UPDATE anggota SET status = ? WHERE user_id = ?");
            $updateAnggota->execute([$statusEnum, $id]);

            $db->commit();
            
            $msg = $newStatus ? "Akun dan Status Anggota diaktifkan." : "Akun dan Status Anggota dinonaktifkan.";
            return $this->redirect('/users', $msg, 'success');

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            return $this->redirect('/users', 'Gagal mengubah status: ' . $e->getMessage(), 'error');
        }
    }

    public function search_ajax() {
        $q = $_GET['q'] ?? '';
        $db = db();
        
        $stmt = $db->prepare("SELECT user_id, nama, identitas_no 
                            FROM anggota 
                            WHERE status = 'AKTIF' 
                            AND (nama LIKE ? OR identitas_no LIKE ?) 
                            LIMIT 10");
        
        $searchTerm = "%$q%";
        $stmt->execute([$searchTerm, $searchTerm]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Bersihkan buffer output sebelum kirim JSON
        if (ob_get_length()) ob_clean(); 
        
        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }

    public function resetPassword($id)
    {
        // Bersihkan output buffer agar tidak ada karakter lain yang ikut terkirim
        if (ob_get_length()) ob_clean();

        if (!$this->isPost()) {
            return $this->json(['success' => false, 'message' => 'Method tidak diizinkan']);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->json(['success' => false, 'message' => 'User tidak ditemukan']);
        }

        // Ambil no_anggota dari tabel anggota
        $db = db();
        $stmt = $db->prepare("SELECT no_anggota FROM anggota WHERE user_id = ?");
        $stmt->execute([$id]);
        $anggota = $stmt->fetch();

        // Gunakan no_anggota sebagai password, fallback ke username jika bukan anggota
        $newPassword = ($anggota && !empty($anggota['no_anggota'])) ? $anggota['no_anggota'] : $user['username'];
        
        $updateData = [
            'password' => $newPassword
        ];

        if ($this->userModel->updateUser($id, $updateData)) {
            return $this->json([
                'success' => true, 
                'message' => 'Password berhasil direset',
                'new_password' => $newPassword
            ]);
        } else {
            return $this->json(['success' => false, 'message' => 'Gagal mengupdate database']);
        }
    }
}
