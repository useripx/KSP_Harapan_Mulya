<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Koperasi Harapan Mulya</title>
    <link rel="icon" type="image/png" href="<?= url('/assets/img/img.png') ?>">

    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?= View::getCsrfToken() ?>">


    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --foreground: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --radius: 0.75rem;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top left, #f8fafc, #eff6ff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: var(--foreground);
            -webkit-font-smoothing: antialiased;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 32px 32px;
            background: #ffffff;
            border-radius: var(--radius);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid var(--border);
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 130px;
            height: 130px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.04em;
            margin-bottom: 8px;
            color: var(--foreground);
        }

        .login-header p {
            font-size: 15px;
            color: var(--muted);
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--foreground);
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #f8fafc;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background: linear-gradient(to bottom right, var(--primary), var(--primary-dark));
            border: none;
            border-radius: var(--radius);
            padding: 12px;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            margin-top: 24px;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
            opacity: 1;
        }

        .login-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        /* Password Toggle Styles */
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
            z-index: 10;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <img src="<?= url('/assets/img/img.png') ?>" alt="Logo">
            </div>
            <h1>Selamat Datang</h1>
            <p>Masuk dengan akun Anda untuk mengakses sistem</p>
        </div>

        <?php View::flash(); ?>

        <form action="<?= url('/login') ?>" method="POST">
            <?= View::csrf() ?>
            <div class="mb-3">
                <label class="form-label">Username / No. Anggota</label>
                <input type="text" name="username" class="form-control" placeholder="Username atau Nomor Anggota..."
                    required autofocus>
            </div>
            <div class="mb-4">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label">Password</label>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal"
                            class="text-decoration-none" style="font-size: 12px; color: var(--muted);">Lupa
                            password?</a>
                    </div>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="passwordInput" class="form-control"
                            placeholder="••••••••" required>
                        <div class="password-toggle" id="passwordToggle">
                            <i class="bi bi-eye"></i>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Masuk</button>
        </form>

        <div class="login-footer">
            &copy; <?= date('Y') ?> Koperasi Harapan Mulya
        </div>
    </div>

    <!-- Modal Lupa Password -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3 text-primary" style="font-size: 40px;">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Lupa Kata Sandi?</h5>
                    <p class="text-muted mb-4">Silahkan hubungi pihak <strong>Koperasi Harapan Mulya</strong> secara
                        langsung, dan membawa Kartu Identitas (KTP,NIM, NIP, atau SIM) untuk melakukan reset atau
                        pembuatan kata sandi baru.</p>
                    <button type="button" class="btn btn-primary px-4 w-100" data-bs-dismiss="modal">Saya
                        Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('passwordInput');
            const passwordToggle = document.getElementById('passwordToggle');
            const toggleIcon = passwordToggle.querySelector('i');

            passwordToggle.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the icon
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>


</html>