<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - Koperasi Harapan Mulya</title>
    <link rel="icon" type="image/png" href="<?= url('/assets/img/img.png') ?>">

    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --foreground: #0f172a;
            --muted: #64748b;
            --muted-foreground: #64748b;
            --border: #e2e8f0;
            --radius: 1rem;
            --card: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top left, #f8fafc, #eff6ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: var(--foreground);
            padding: 20px;
        }

        .reset-card {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            border-radius: var(--radius);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header-custom {
            padding: 40px 40px 20px;
            text-align: center;
        }

        .warning-icon {
            width: 80px;
            height: 80px;
            background: #fffbeb;
            color: #f59e0b;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 24px;
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.1);
        }

        .card-body {
            padding: 0 40px 40px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--foreground);
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 12px 16px;
            font-size: 15px;
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .password-requirements {
            background: #f1f5f9;
            border-radius: 0.75rem;
            padding: 16px;
            margin-bottom: 24px;
        }

        .requirement-item {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .requirement-item i {
            font-size: 14px;
        }

        .requirement-item.valid {
            color: #10b981;
        }

        .requirement-item.invalid {
            color: #ef4444;
        }

        .btn-primary {
            background: linear-gradient(to bottom right, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 0.75rem;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.15);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            padding: 5px;
            display: flex;
        }

        /* Premium Custom SweetAlert2 Override Styles */
        .swal2-popup.modern-swal-popup {
            background: var(--card) !important;
            color: var(--foreground) !important;
            border-radius: 1.25rem !important;
            border: 1px solid var(--border) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12), 0 0 1px 1px var(--border) !important;
            padding: 2.25rem 1.75rem !important;
            font-family: 'Inter', sans-serif !important;
        }

        .swal2-title.modern-swal-title {
            color: var(--foreground) !important;
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.03em !important;
            margin-bottom: 0.5rem !important;
        }

        .swal2-html-container.modern-swal-html {
            color: var(--muted-foreground) !important;
            font-size: 0.95rem !important;
            line-height: 1.6 !important;
            font-weight: 500 !important;
        }

        .swal2-confirm.modern-swal-confirm-btn {
            background: linear-gradient(to bottom right, var(--primary), var(--primary-dark)) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 0.75rem !important;
            padding: 10px 24px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.15) !important;
            transition: all 0.2s !important;
        }

        .swal2-confirm.modern-swal-confirm-btn:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.25) !important;
            opacity: 0.95 !important;
        }

        .swal2-confirm.modern-swal-confirm-btn:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3) !important;
        }

        /* Glassmorphic Backdrop blur with saturate */
        .swal2-backdrop-show {
            backdrop-filter: blur(8px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(8px) saturate(140%) !important;
            background-color: rgba(15, 23, 42, 0.25) !important;
        }

        /* Custom SweetAlert2 Icons */
        .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            color: #10b981 !important;
        }
        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #10b981 !important;
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border: 4px solid rgba(16, 185, 129, 0.2) !important;
        }
        .swal2-icon.swal2-error {
            border-color: #ef4444 !important;
            color: #ef4444 !important;
        }
        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
            background-color: #ef4444 !important;
        }
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
        }
        .swal2-icon.swal2-info {
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
        }
    </style>

    <!-- SweetAlert2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</head>

<body>
    <div class="reset-card">
        <div class="card-header-custom">
            <div class="warning-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h4 class="fw-bold mb-2">Peringatan Keamanan!</h4>
            <p class="text-muted small">Sandi Anda saat ini masih menggunakan Default ID Anggota/Username. Demi keamanan akun Anda, silakan ganti sandi Anda sekarang.</p>
        </div>

        <div class="card-body">
            <form action="<?= url('/force-password') ?>" method="POST" id="resetForm">
                <?= View::csrf() ?>
                
                <div class="password-requirements mb-4">
                    <div class="fw-bold small mb-2 text-dark">Kriteria Password Baru:</div>
                    <div id="req-length" class="requirement-item">
                        <i class="bi bi-circle"></i> Minimal 6 Karakter
                    </div>
                    <div id="req-upper" class="requirement-item">
                        <i class="bi bi-circle"></i> Mengandung Huruf Besar (A-Z)
                    </div>
                    <div id="req-lower" class="requirement-item">
                        <i class="bi bi-circle"></i> Mengandung Huruf Kecil (a-z)
                    </div>
                    <div id="req-number" class="requirement-item">
                        <i class="bi bi-circle"></i> Mengandung Angka (0-9)
                    </div>
                    <div id="req-match" class="requirement-item">
                        <i class="bi bi-circle"></i> Password Cocok
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" name="new_password" id="newPassword" 
                            class="form-control <?= isset($errors['new_password']) ? 'is-invalid' : '' ?>" 
                            placeholder="Ketik password baru..." required autofocus>
                        <div class="password-toggle" onclick="togglePassword('newPassword', this)">
                            <i class="bi bi-eye"></i>
                        </div>
                    </div>
                    <?php if (isset($errors['new_password'])): ?>
                        <div class="text-danger small mt-1"><?= $errors['new_password'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="confirmPassword" 
                            class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" 
                            placeholder="Ulangi password baru..." required>
                        <div class="password-toggle" onclick="togglePassword('confirmPassword', this)">
                            <i class="bi bi-eye"></i>
                        </div>
                    </div>
                    <div id="match-error" class="text-danger small mt-1 d-none">Password konfirmasi tidak sesuai!</div>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <div class="text-danger small mt-1"><?= $errors['confirm_password'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary" disabled>
                    Simpan Sandi & Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="<?= url('/logout') ?>" class="text-decoration-none text-muted small">
                    <i class="bi bi-box-arrow-left me-1"></i> Keluar & Batalkan
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        const newPass = document.getElementById('newPassword');
        const confirmPass = document.getElementById('confirmPassword');
        const submitBtn = document.getElementById('submitBtn');
        const matchError = document.getElementById('match-error');

        const reqs = {
            length: document.getElementById('req-length'),
            upper: document.getElementById('req-upper'),
            lower: document.getElementById('req-lower'),
            number: document.getElementById('req-number'),
            match: document.getElementById('req-match')
        };

        function validate() {
            const val = newPass.value;
            const confVal = confirmPass.value;
            
            const checks = {
                length: val.length >= 6,
                upper: /[A-Z]/.test(val),
                lower: /[a-z]/.test(val),
                number: /[0-9]/.test(val)
            };

            let allValid = true;
            for (const key in checks) {
                const isValid = checks[key];
                const item = reqs[key];
                const icon = item.querySelector('i');
                
                if (isValid) {
                    item.classList.add('valid');
                    item.classList.remove('invalid');
                    icon.classList.replace('bi-circle', 'bi-check-circle-fill');
                    icon.classList.replace('bi-x-circle-fill', 'bi-check-circle-fill');
                } else {
                    item.classList.remove('valid');
                    if (val.length > 0) item.classList.add('invalid');
                    icon.classList.replace('bi-check-circle-fill', 'bi-circle');
                    allValid = false;
                }
            }

            // Match Check
            const match = val === confVal && val.length > 0;
            const matchIcon = reqs.match.querySelector('i');
            
            if (match) {
                reqs.match.classList.add('valid');
                reqs.match.classList.remove('invalid');
                matchIcon.classList.replace('bi-circle', 'bi-check-circle-fill');
                matchIcon.classList.replace('bi-x-circle-fill', 'bi-check-circle-fill');
                matchError.classList.add('d-none');
            } else {
                reqs.match.classList.remove('valid');
                if (confVal.length > 0) {
                    reqs.match.classList.add('invalid');
                    matchIcon.classList.replace('bi-circle', 'bi-x-circle-fill');
                    matchIcon.classList.replace('bi-check-circle-fill', 'bi-x-circle-fill');
                    matchError.classList.remove('d-none');
                } else {
                    reqs.match.classList.remove('invalid');
                    matchIcon.classList.replace('bi-x-circle-fill', 'bi-circle');
                    matchIcon.classList.replace('bi-check-circle-fill', 'bi-circle');
                    matchError.classList.add('d-none');
                }
            }

            submitBtn.disabled = !(allValid && match);
        }

        newPass.addEventListener('input', validate);
        confirmPass.addEventListener('input', validate);
    </script>
</body>

</html>
