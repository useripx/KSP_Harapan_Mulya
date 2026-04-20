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
            'name' => 'required',
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

        $this->view('user/edit', [
            'pageTitle' => 'Edit User',
            'user' => $user,
            'roles' => [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA]
        ]);
    }

    public function update($id)
    {
        $data = $this->post();

        $rules = [
            'name' => 'required',
            'username' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required'
        ];

        $errors = $this->validate($data, $rules);

        if ($this->userModel->usernameExists($data['username'], $id)) {
            $errors['username'] = 'Username sudah digunakan';
        }

        if ($this->userModel->emailExists($data['email'], $id)) {
            $errors['email'] = 'Email sudah digunakan';
        }

        if (!empty($errors)) {
            $user = $this->userModel->find($id);
            return $this->view('user/edit', [
                'pageTitle' => 'Edit User',
                'user' => $user,
                'errors' => $errors,
                'old' => $data,
                'roles' => [ROLE_ADMIN, ROLE_TELLER, ROLE_KETUA, ROLE_ANGGOTA]
            ]);
        }

        $updateData = [
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'is_active' => isset($data['is_active']) ? 1 : 0
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        if ($this->userModel->updateUser($id, $updateData)) {
            $this->redirect('/users', 'User berhasil diperbarui', 'success');
        } else {
            $this->redirect("/users/{$id}/edit", 'Gagal memperbarui user', 'error');
        }
    }

    public function delete($id)
    {
        if ($id == Auth::id()) {
            $this->redirect('/users', 'Tidak dapat menghapus diri sendiri', 'error');
        }

        if ($this->userModel->delete($id)) {
            $this->redirect('/users', 'User berhasil dihapus', 'success');
        } else {
            $this->redirect('/users', 'Gagal menghapus user', 'error');
        }
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            $this->redirect('/users', 'User tidak ditemukan', 'error');
        }

        if ($id == Auth::id()) {
            $this->redirect('/users', 'Tidak dapat menonaktifkan diri sendiri', 'error');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        if ($this->userModel->changeStatus($id, $newStatus)) {
            $statusLabel = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            $this->redirect('/users', "User berhasil {$statusLabel}", 'success');
        } else {
            $this->redirect('/users', 'Gagal mengubah status user', 'error');
        }
    }
}
