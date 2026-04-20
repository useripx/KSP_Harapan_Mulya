<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="page-title mb-0">Manajemen User</h1>
            <p class="card-description-text mt-1">Kelola akses akun administrator, teller, ketua, dan anggota.</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= url('/users/create') ?>" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i>
                Tambah User
            </a>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 stat-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people text-primary fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="stat-label mb-0">Total User</div>
                            <div class="stat-value mb-0">
                                <?= $stats['total'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 stat-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-person-check text-success fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="stat-label mb-0">User Aktif</div>
                            <div class="stat-value mb-0">
                                <?= $stats['active'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 stat-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-shield-lock text-warning fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="stat-label mb-0">Administrator</div>
                            <div class="stat-value mb-0">
                                <?= $stats['admin'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 stat-card">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-person-badge text-info fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="stat-label mb-0">Teller</div>
                            <div class="stat-value mb-0">
                                <?= $stats['teller'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">User</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Last Login</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            <span class="text-primary fw-bold">
                                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-bold fs-6">
                                                <?= htmlspecialchars($user['name']) ?>
                                            </div>
                                            <div class="text-muted small">
                                                <?= htmlspecialchars($user['username']) ?> |
                                                <?= htmlspecialchars($user['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $badgeClass = 'bg-secondary';
                                    if ($user['role'] === 'ADMIN')
                                        $badgeClass = 'bg-danger';
                                    elseif ($user['role'] === 'TELLER')
                                        $badgeClass = 'bg-primary';
                                    elseif ($user['role'] === 'KETUA')
                                        $badgeClass = 'bg-warning text-dark';
                                    elseif ($user['role'] === 'ANGGOTA')
                                        $badgeClass = 'bg-info text-dark';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= $user['role'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['is_active']): ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                class="badge bg-success-soft text-success border border-success border-opacity-25">
                                                <i class="bi bi-check-circle me-1"></i> Aktif
                                            </span>
                                            <?php if ($user['id'] != Auth::id()): ?>
                                                <form action="<?= url("/users/{$user['id']}/toggle-status") ?>" method="POST"
                                                    class="d-inline">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1"
                                                        title="Nonaktifkan">
                                                        <i class="bi bi-power"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                class="badge bg-danger-soft text-danger border border-danger border-opacity-25">
                                                <i class="bi bi-x-circle me-1"></i> Non-Aktif
                                            </span>
                                            <form action="<?= url("/users/{$user['id']}/toggle-status") ?>" method="POST"
                                                class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-outline-success py-0 px-1"
                                                    title="Aktifkan">
                                                    <i class="bi bi-power"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        <?= $user['last_login_at'] ? date('d/m/Y H:i', strtotime($user['last_login_at'])) : '-' ?>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-icon btn-light btn-sm rounded-circle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item" href="<?= url("/users/{$user['id']}/edit") ?>"><i
                                                        class="bi bi-pencil me-2"></i> Edit</a></li>
                                            <?php if ($user['id'] != Auth::id()): ?>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="<?= url("/users/{$user['id']}/delete") ?>" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                                        <button type="submit" class="dropdown-item text-danger"><i
                                                                class="bi bi-trash me-2"></i> Hapus</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>