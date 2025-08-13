<?php
if (!isset($active)) $active = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sidebar Admin</title>
</head>
<body style="margin:0; font-family: Arial, sans-serif;">

<!-- SIDEBAR -->
<aside role="navigation" aria-label="Sidebar Admin" style="
    width: 240px;
    height: 100vh;
    background-color: #2c3e50;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
">
    <!-- Brand -->
    <div>
        <div style="padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <img src="assets/img/kemara.png" alt="Logo Admin" style="width: 60px; height: 60px; border-radius: 50%;">
            <div style="margin-top: 10px; font-weight: bold;">Admin</div>
        </div>

        <!-- Menu -->
        <nav aria-label="Main menu" style="display: flex; flex-direction: column;">
            <a href="dashboard_admin.php" style="
                padding: 12px 20px;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                background-color: <?= $active === 'dashboard' ? '#34495e' : 'transparent' ?>;
            ">
                <span style="margin-right: 10px;">🏠</span>
                Dashboard
            </a>

            <a href="management_akun.php" style="
                padding: 12px 20px;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                background-color: <?= $active === 'manajemen' ? '#34495e' : 'transparent' ?>;
            ">
                <span style="margin-right: 10px;">👥</span>
                Manajemen Pendaftar
            </a>

            <a href="verifikasi.php" style="
                padding: 12px 20px;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                background-color: <?= $active === 'verifikasi' ? '#34495e' : 'transparent' ?>;
            ">
                <span style="margin-right: 10px;">📝</span>
                Verifikasi Data
            </a>

            <a href="statistik.php" style="
                padding: 12px 20px;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                background-color: <?= $active === 'statistik' ? '#34495e' : 'transparent' ?>;
            ">
                <span style="margin-right: 10px;">📊</span>
                Statistik Pendaftaran
            </a>

            <a href="pengaturan.php" style="
                padding: 12px 20px;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                background-color: <?= $active === 'pengaturan' ? '#34495e' : 'transparent' ?>;
            ">
                <span style="margin-right: 10px;">⚙️</span>
                Pengaturan Admin
            </a>
        </nav>
    </div>

    <!-- Bottom Menu -->
    <div>
        <a href="help.php" style="
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-top: 1px solid rgba(255,255,255,0.1);
        ">
            <span style="margin-right: 10px;">❓</span>
            Help
        </a>
        <a href="logout.php" style="
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-top: 1px solid rgba(255,255,255,0.1);
        ">
            <span style="margin-right: 10px;">🔒</span>
            Logout
        </a>
    </div>
</aside>

</body>
</html>
