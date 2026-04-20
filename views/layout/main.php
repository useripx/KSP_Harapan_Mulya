<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - KSP Harapan Mulya</title>

    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Theme Initializer -->
    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

    <?= csrfMeta() ?>

    <style>
        :root {
            /* Light Theme (Default) */
            --background: #f8fafc;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --popover: #ffffff;
            --popover-foreground: #0f172a;
            --primary: #2563eb;
            --primary-foreground: #ffffff;
            --secondary: #f1f5f9;
            --secondary-foreground: #1e293b;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --accent: #f1f5f9;
            --accent-foreground: #0f172a;
            --destructive: #ef4444;
            --destructive-foreground: #ffffff;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --ring: #3b82f6;
            --radius: 0.75rem;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --sidebar-bg: #ffffff;
            --topbar-bg: rgba(255, 255, 255, 0.7);
        }

        [data-theme="dark"] {
            --background: #020617;
            --foreground: #f8fafc;
            --card: #0f172a;
            --card-foreground: #f8fafc;
            --popover: #0f172a;
            --popover-foreground: #f8fafc;
            --primary: #3b82f6;
            --primary-foreground: #ffffff;
            --secondary: #1e293b;
            --secondary-foreground: #f1f5f9;
            --muted: #1e293b;
            --muted-foreground: #cbd5e1;
            /* Extra bright for accessibility */
            --accent: #1e293b;
            --accent-foreground: #f8fafc;
            --destructive: #7f1d1d;
            --destructive-foreground: #fef2f2;
            --border: #1e293b;
            --input: #1e293b;
            --ring: #2563eb;
            --sidebar-bg: #0f172a;
            --topbar-bg: rgba(15, 23, 42, 0.7);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6 {
            color: var(--foreground) !important;
        }

        /* Sidebar & Navigation Upgrade */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            padding: 24px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 0 24px 32px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .sidebar-header h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.03em;
            color: var(--foreground);
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-header h4 {
            opacity: 0;
            visibility: hidden;
        }

        .user-avatar-large {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            background: linear-gradient(135deg, var(--primary), #3b82f6) !important;
            color: white !important;
        }

        .sidebar-section {
            padding: 0 16px;
            margin-top: 24px;
        }

        .sidebar-label {
            padding: 0 12px;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted-foreground);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
            opacity: 0.7;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 2px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: var(--muted-foreground);
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background-color: var(--secondary);
            color: var(--primary);
            transform: translateX(4px);
        }

        .sidebar-menu a.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .sidebar-menu a i {
            width: 20px;
            font-size: 1.25rem;
            margin-right: 14px;
            flex-shrink: 0;
        }

        .sidebar.collapsed .sidebar-menu a span,
        .sidebar.collapsed .sidebar-label {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 12px;
            transform: none;
        }

        .sidebar.collapsed .sidebar-menu a i {
            margin-right: 0;
        }

        /* Topbar & Header Components */
        .topbar {
            background-color: var(--topbar-bg);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            padding: 0 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 72px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .toggle-btn {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--foreground);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .toggle-btn:hover {
            background: var(--secondary);
            border-color: var(--ring);
            color: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .toggle-btn i {
            font-size: 1.25rem;
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--foreground);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 10px 15px -5px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }

        /* Fixed background for tables and other components */
        .table thead th {
            border-bottom: 1px solid var(--border);
            color: var(--muted-foreground);
            background-color: var(--card);
        }

        .table tbody td {
            color: var(--foreground);
            border-bottom: 1px solid var(--border);
            background-color: var(--card);
        }

        [data-theme="dark"] .table {
            background-color: var(--card) !important;
            border-color: var(--border) !important;
            color: var(--foreground) !important;
        }

        [data-theme="dark"] .table thead th,
        [data-theme="dark"] .table tbody td {
            background-color: transparent !important;
            border-color: var(--border) !important;
            color: var(--foreground) !important;
        }

        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: var(--secondary) !important;
        }

        .form-control,
        .form-select {
            background-color: var(--card);
            border-color: var(--border);
            color: var(--foreground);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--card);
            color: var(--foreground);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: var(--muted-foreground);
            opacity: 0.5;
        }

        .text-muted {
            color: var(--muted-foreground) !important;
        }

        [data-theme="dark"] .text-dark,
        [data-theme="dark"] .text-gray-800,
        [data-theme="dark"] .text-gray-900 {
            color: var(--foreground) !important;
        }

        .bg-white,
        .bg-light,
        .bg-gray-100 {
            background-color: var(--card) !important;
        }

        [data-theme="dark"] .bg-white,
        [data-theme="dark"] .bg-light,
        [data-theme="dark"] .bg-gray-100 {
            background-color: var(--card) !important;
        }

        [data-theme="dark"] .bg-light:not(.btn) {
            background-color: var(--secondary) !important;
            color: var(--foreground) !important;
        }

        /* Dropdown Theme Support */
        [data-theme="dark"] .dropdown-menu {
            background-color: var(--card) !important;
            border-color: var(--border) !important;
            color: var(--foreground) !important;
        }

        [data-theme="dark"] .dropdown-item {
            color: var(--foreground) !important;
        }

        [data-theme="dark"] .dropdown-item:hover {
            background-color: var(--secondary) !important;
            color: var(--primary) !important;
        }

        [data-theme="dark"] .dropdown-divider {
            border-color: var(--border) !important;
            opacity: 0.2;
        }

        [data-theme="dark"] .dropdown-header {
            color: var(--muted-foreground) !important;
        }

        .card-body label,
        .form-label {
            color: var(--foreground);
            font-weight: 600;
        }

        p.fw-semibold,
        .fw-bold {
            color: var(--foreground) !important;
        }

        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }


        .card-header {
            padding: 24px 32px;
            background: transparent;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--foreground);
        }

        .btn {
            font-weight: 600;
            padding: 10px 20px;
            border-radius: var(--radius);
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(to bottom right, #2563eb, #1d4ed8);
            border: none;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
            background: linear-gradient(to bottom right, #3b82f6, #2563eb);
        }

        /* Stats Upgrades */
        .stat-card {
            padding: 32px;
            position: relative;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            background: var(--secondary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--primary);
            font-size: 24px;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--muted-foreground);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        [data-theme="dark"] .border-bottom,
        [data-theme="dark"] .border-top,
        [data-theme="dark"] .border {
            border-color: var(--border) !important;
        }

        [data-theme="dark"] .text-muted,
        [data-theme="dark"] .small.text-muted {
            color: var(--muted-foreground) !important;
        }

        [data-theme="dark"] .fw-semibold,
        [data-theme="dark"] .fw-bold,
        [data-theme="dark"] strong {
            color: var(--foreground) !important;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--foreground);
            margin-bottom: 4px;
        }

        .stat-footer {
            font-size: 13px;
            color: var(--muted-foreground);
        }

        /* Modern Badges */
        .badge {
            padding: 6px 12px;
            font-weight: 700;
            border-radius: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Dark Mode Utility Polish */
        [data-theme="dark"] .bg-primary.bg-opacity-10,
        [data-theme="dark"] .bg-primary-subtle {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #93c5fd !important;
        }

        [data-theme="dark"] .bg-info.bg-opacity-10,
        [data-theme="dark"] .bg-info-subtle {
            background-color: rgba(6, 182, 212, 0.15) !important;
            color: #67e8f9 !important;
        }

        [data-theme="dark"] .bg-success.bg-opacity-10,
        [data-theme="dark"] .bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.15) !important;
            color: #86efac !important;
        }

        [data-theme="dark"] .text-primary {
            color: #60a5fa !important;
        }

        [data-theme="dark"] .text-info {
            color: #67e8f9 !important;
        }

        [data-theme="dark"] .text-success {
            color: #86efac !important;
        }

        [data-theme="dark"] .stat-icon-wrapper {
            background-color: var(--secondary) !important;
        }

        /* Card Descriptions & Headers */
        .card-description-text {
            font-size: 13px;
            color: var(--muted-foreground);
            margin-bottom: 0;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .topbar {
                padding: 0 20px;
            }
        }
    </style>

    <?= $additionalCSS ?? '' ?>
</head>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <?php require_once __DIR__ . '/topbar.php'; ?>

        <!-- Content Area -->
        <div class="container-fluid py-4 px-4">
            <?php View::flash(); ?>
            <?= $content ?>
        </div>

        <!-- Footer -->
        <?php require_once __DIR__ . '/footer.php'; ?>
    </div>

    <!-- Bootstrap 5.3.8 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', function (e) {
            if (window.innerWidth <= 992) {
                // Mobile View
                e.stopPropagation();
                sidebar.classList.toggle('active');
            } else {
                // Desktop View
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        });

        // Close sidebar on mobile when click outside
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Restore sidebar state for Desktop Only
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (sidebarCollapsed && window.innerWidth > 992) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }

        // Theme Toggle Support
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-theme', newTheme);
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Update Icon
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.querySelector('#themeToggle i');
            if (icon) {
                if (theme === 'dark') {
                    icon.classList.remove('bi-moon-fill');
                    icon.classList.add('bi-sun-fill');
                } else {
                    icon.classList.remove('bi-sun-fill');
                    icon.classList.add('bi-moon-fill');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            updateThemeIcon(savedTheme);
        });
    </script>

    Chatbot Widget
    <!-- <?php // require_once __DIR__ . '/chatbot.php'; ?> -->
    <!-- <script src="<?= url('js/chatbot.js') ?>"></script> -->

    <?= $additionalJS ?? '' ?>
</body>

</html>