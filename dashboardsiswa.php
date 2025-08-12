<?php
session_start();

// Redirect kalau belum login
if (!isset($_SESSION['email'])) {
    header("Location: loginsiswa.php");
    exit();
}

$nama = $_SESSION['nama_lengkap'];
?>

<h1>Selamat datang, <?php echo htmlspecialchars($nama); ?>!</h1>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Siswa</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="sidebar-container">
    <h2 class="sidebar-title">Smart</h2>
    <ul class="sidebar-menu">
      <li class="menu-item">Dashboard</li>
      <li class="menu-item">Lessons</li>
      <li class="menu-item">Schedule</li>
      <li class="menu-item">Materials</li>
      <li class="menu-item">Forum</li>
      <li class="menu-item">Assessments</li>
      <li class="menu-item">Settings</li>
    </ul>
    <button class="logout-button">Log Out</button>
  </div>

  <div class="content-area">
    <div class="header-bar">
      <input type="text" class="search-input" placeholder="Search..." />
    </div>

    <div class="greeting-section">
      <h3 class="greeting-title">Hello <?= htmlspecialchars($nama) ?>!</h3>
      <p class="greeting-text">You have 3 new tasks. Let's get started!</p>
      <a href="#" class="greeting-link">Review it!</a>
    </div>

    <div class="dashboard-cards">
      <div class="dashboard-card card-performance">
        <h4 class="card-title">Performance</h4>
        <p class="card-text">Best lessons: 95.4</p>
        <div class="bar-chart">
          <div class="bar-column" style="height: 85%"></div>
          <div class="bar-column" style="height: 64%"></div>
          <div class="bar-column" style="height: 72%"></div>
          <div class="bar-column" style="height: 68%"></div>
        </div>
      </div>

      <div class="dashboard-card card-schedule">
        <h4 class="card-title">Today's Schedule</h4>
        <ul class="schedule-list">
          <li class="schedule-item">08:45 - 10:30 Electronics</li>
          <li class="schedule-item">11:00 - 12:00 Robotics</li>
          <li class="schedule-item">13:00 - 14:30 C++</li>
        </ul>
      </div>

      <div class="dashboard-card card-events">
        <h4 class="card-title">Upcoming Events</h4>
        <ul class="event-list">
          <li class="event-item">Robot Fest - Dec 4, 2025</li>
          <li class="event-item">Webinar - Dec 21, 2025</li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
