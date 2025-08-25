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
        <img src="assets/img/tutwuri.png" alt="Logo Admin" class="brand-logo-img">
        <div class="brand-name">Tata Usaha</div>
    </div>

    <nav class="menu" aria-label="Main menu">
        <a href="dashboard_tu.php" class="menu-item <?= $active === 'dashboard' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">🏠</span>
            <span class="label">Dashboard</span>
        </a>

         <a href="keloladata_tu.php" class="menu-item <?= $active === 'manajemen' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">👥</span>
            <span class="label">Kelola Data Siswa</span>
        </a>

         <a href="input_nilai.php" class="menu-item <?= $active === 'manajemen' ? 'active' : '' ?>">
            <span class="icon" aria-hidden="true">📝</span>
            <span class="label">Input Nilai Siswa</span>
        </a>
      
    </nav>

    

    <div class="sidebar-bottom">

        <a href="login.php" class="bottom-item">
            <span class="icon" aria-hidden="true">🔒</span>
            <span class="label">Logout</span>
        </a>
    </div>
</aside>



</body>
</html>
