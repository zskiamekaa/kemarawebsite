<?php
if (!isset($active)) $active = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sidebar Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #E8E0D5;
        }

        /* SIDEBAR */
        aside {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            backdrop-filter: blur(4px);
            box-shadow: 5px 0 15px rgba(0,0,0,0.2);
            border-right: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        /* Brand */
        .brand {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .brand img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .brand img:hover {
            transform: scale(1.15);
            box-shadow: 0 0 15px rgba(255,255,255,0.3);
        }

        .brand-name {
            margin-top: 12px;
            font-weight: bold;
            font-size: 16px;
            letter-spacing: 1px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }

        /* Menu */
        .brand {
    padding: 15px 20px; /* dikurangi agar menu lebih dekat */
}

nav {
    display: flex;
    flex-direction: column;
    margin-top: 0; /* benar-benar menempel */
}


        nav a {
            padding: 14px 25px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 15px;
            border-radius: 0 25px 25px 0;
            margin: 4px 0;
            position: relative;
            transition: all 0.3s ease;
        }

        nav a span {
            margin-right: 15px;
            font-size: 17px;
        }

        nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background-color: #DF7924;
            border-radius: 0 25px 25px 0;
            transition: width 0.3s ease;
            z-index: -1;
        }

        nav a:hover::before {
            width: 100%;
        }

        nav a:hover {
            color: #fff;
            transform: translateX(5px);
        }

        nav a.active {
            background-color: #DF7924;
            color: white;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        /* Bottom Menu */
        .bottom-menu {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
        }

        .bottom-menu a {
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
            border-radius: 0 25px 25px 0;
            margin: 2px 0;
            border-top: 1px solid rgba(255,255,255,0.15);
            transition: all 0.3s ease;
            position: relative;
        }

        .bottom-menu a span {
            margin-right: 12px;
            font-size: 16px;
        }

        .bottom-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background-color: #DF7924;
            border-radius: 0 25px 25px 0;
            transition: width 0.3s ease;
            z-index: -1;
        }

        .bottom-menu a:hover::before {
            width: 100%;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            aside {
                width: 200px;
            }

            nav a {
                padding: 12px 20px;
                font-size: 14px;
            }

            .brand img {
                width: 70px;
                height: 70px;
            }

            .brand-name {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            aside {
                width: 60px;
            }

            nav a {
                justify-content: center;
                padding: 10px 0;
            }

            nav a span {
                margin-right: 0;
            }

            .brand-name {
                display: none;
            }
        }
    </style>
</head>
<body>

<aside role="navigation" aria-label="Sidebar Admin">
    <!-- Brand -->
    <div class="brand">
        <img src="assets/img/kemara.png" alt="Logo Admin">
        <div class="brand-name">Admin</div>
    </div>

    <!-- Menu -->
    <nav aria-label="Main menu">
        <a href="dashboard_admin.php" class="<?= $active === 'dashboard' ? 'active' : '' ?>">
            <span>🏠</span>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="management_akun.php" class="<?= $active === 'manajemen' ? 'active' : '' ?>">
            <span>👥</span>
            <span class="menu-text">Manajemen Pendaftar</span>
        </a>

        <a href="statistik_pendaftaran.php" class="<?= $active === 'statistik' ? 'active' : '' ?>">
            <span>📊</span>
            <span class="menu-text">Statistik Pendaftaran</span>
        </a>
    </nav>

    <!-- Bottom Menu -->
    <div class="bottom-menu">
        <a href="loginadmin.php">
            <span>🔒</span>
            <span class="menu-text">Logout</span>
        </a>
    </div>
</aside>

</body>
</html>
