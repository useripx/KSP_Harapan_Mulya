<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="page-title mb-0">Manajemen User</h2>
        <p class="text-muted small mb-0">Kelola akses akun Validator, Manager, BAU, dan Anggota</p>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="userSearchInput" class="form-control border-start-0 ps-0"
                placeholder="Cari Nama/Email/Username...">
        </div>
        <a href="<?= url('/users/create') ?>"
            class="btn btn-primary btn-sm shadow-sm px-3 d-flex align-items-center gap-2">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm shadow-sm rounded fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Statistik Ringkas -->
<div class="row mb-4">
    <div class="col-md-6">
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
    <div class="col-md-6">
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
                <tbody id="userTableBody">
                    <?php foreach ($users as $user): ?>
                        <tr class="user-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <span class="text-primary fw-bold">
                                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-6 text-gray-800">
                                            <?= e($user['name']) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= e($user['username']) ?> |
                                            <?= e($user['email']) ?>
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
                                        <span class="badge bg-danger-soft text-danger border border-danger border-opacity-25">
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
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($users) && count($users) > 5): ?>
            <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light rounded-bottom">
                <div class="small fw-medium text-muted" id="user-page-info">
                    Menampilkan data...
                </div>
                <div class="btn-group shadow-sm">
                    <button id="user-prev-btn" class="btn btn-white border btn-sm text-primary fw-semibold"
                        onclick="changeUserPage(-1)">
                        <i class="bi bi-chevron-left me-1"></i> Prev
                    </button>
                    <button id="user-next-btn" class="btn btn-white border btn-sm text-primary fw-semibold"
                        onclick="changeUserPage(1)">
                        Next <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("userSearchInput");
        const allRows = Array.from(document.querySelectorAll("#userTableBody .user-row"));
        const rowsPerPage = 5;
        let currentPage = 1;
        let filteredRows = [...allRows];

        function updateTable() {
            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Hide all rows
            allRows.forEach(row => row.style.display = "none");

            // Show matching rows for current page
            filteredRows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = "";
                }
            });

            // Update info text
            const infoText = document.getElementById("user-page-info");
            if (infoText) {
                if (totalRows === 0) {
                    infoText.innerText = "Tidak ada data yang cocok";
                } else {
                    const currentEnd = Math.min(end, totalRows);
                    infoText.innerText = `Menampilkan ${start + 1}-${currentEnd} dari total ${totalRows} user`;
                }
            }

            // Update pagination buttons
            const prevBtn = document.getElementById("user-prev-btn");
            const nextBtn = document.getElementById("user-next-btn");

            if (prevBtn) prevBtn.disabled = (currentPage === 1);
            if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
        }

        // Search Logic
        if (searchInput) {
            searchInput.addEventListener("input", function () {
                const query = this.value.toLowerCase();

                filteredRows = allRows.filter(row => {
                    const text = row.innerText.toLowerCase();
                    return text.includes(query);
                });

                currentPage = 1;
                updateTable();
            });
        }

        // Init
        updateTable();

        window.changeUserPage = function (step) {
            currentPage += step;
            updateTable();
        };
    });
</script>

<style>
    .btn-white {
        background-color: #ffffff;
    }

    .btn-white:hover:not(:disabled) {
        background-color: #f8fafc;
        color: #1e40af !important;
    }

    .btn-white:disabled {
        background-color: #f1f5f9;
        color: #94a3b8 !important;
        cursor: not-allowed;
    }
</style>