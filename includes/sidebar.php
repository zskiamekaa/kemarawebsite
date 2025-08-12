<?php

if (!isset($active)) $active = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    
     <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>



<!-- SIDEBAR -->
<aside class="admin-sidebar" role="navigation" aria-label="Sidebar Admin">
    <div class="brand">
        <img src="assets/img/kemara.png" alt="Logo Admin" class="brand-logo-img">
        <div class="brand-name">Admin</div>
    </div>

    <nav class="menu" aria-label="Main menu">
        <a href="dashboard_admin.php" class="menu-item <?= $active === 'dashboard' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">🏠</span>
            <span class="label">Dashboard</span>
        </a>

        <a href="management_akun.php" class="menu-item <?= $active === 'manajemen' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">👥</span>
            <span class="label">Manajemen Pendaftar</span>
        </a>

        <a href="verifikasi.php" class="menu-item <?= $active === 'verifikasi' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">📝</span>
            <span class="label">Verifikasi Data</span>
        </a>

        <a href="statistik.php" class="menu-item <?= $active === 'statistik' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">📊</span>
            <span class="label">Statistik Pendaftaran</span>
        </a>

        <a href="pengaturan.php" class="menu-item <?= $active === 'pengaturan' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">⚙️</span>
            <span class="label">Pengaturan Admin</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <a href="help.php" class="bottom-item">
            <span class="icon" aria-hidden="true">❓</span>
            <span class="label">Help</span>
        </a>
        <a href="logout.php" class="bottom-item">
            <span class="icon" aria-hidden="true">🔒</span>
            <span class="label">Logout</span>
        </a>
    </div>
</aside>



</body>
</html>
