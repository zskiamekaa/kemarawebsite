<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kemara Schools</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    
<header>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="assets/img/logo_kemara.png" alt="Kemara Schools" class="logo-img">
            </a>
        </div>
        
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>

            <li class="dropdown">
                <a href="#">Profile</a>
                <ul class="dropdown-content">
                    <li><a href="profile.php#tentang">Tentang Kami</a></li>
                    <li><a href="profile.php#visi">Visi dan Misi</a></li>
                    <li><a href="profile.php#teacher">Staff dan Guru</a></li>
                    <li><a href="profile.php#fasilitas">Fasilitas</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#">Pendaftaran</a>
                <ul class="dropdown-content">
                    <li><a href="pendaftaran.php#syarat">Syarat</a></li>
                    <li><a href="pendaftaran.php#formulir">Formulir</a></li>
                </ul>
            </li>
        </ul>

        <a href="formulir.php" class="btn-daftar">Daftar Siswa Baru</a>
    </div>
</header>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const dropdowns = document.querySelectorAll(".dropdown > a");

    dropdowns.forEach(function(dropdownToggle) {
      dropdownToggle.addEventListener("click", function(e) {
        e.preventDefault();
        
        document.querySelectorAll(".dropdown").forEach(function(d) {
          if (d !== this.parentElement) {
            d.classList.remove("active");
          }
        }.bind(this));

        this.parentElement.classList.toggle("active");
      });
    });

    
    document.addEventListener("click", function(e) {
      if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown").forEach(function(drop) {
          drop.classList.remove("active");
        });
      }
    });
  });
</script>

</body>
</html>
