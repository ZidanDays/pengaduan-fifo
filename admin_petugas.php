<?php
session_start();
include 'koneksi.php';

// Cek apakah admin/petugas sudah login
if(!isset($_SESSION['level'])){
    header("location: index.php");
    exit();
}

$level = $_SESSION['level'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard Admin - DLH Minahasa</title>

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    /* Kostumisasi Badge untuk Role di Hero Section */
    .role-badge {
        background-color: #059669; /* Hijau DLH */
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: bold;
        display: inline-block;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="admin_petugas.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Panel Admin DLH</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
            <?php if ($level == 'petugas') { ?>
                <li><a href="admin_petugas.php" class="active">Home</a></li>
                <li><a href="data_pengaduan_petugas.php">Data Pengaduan</a></li>
                <li><a href="data_masarakat_ptgs.php">Data Masyarakat</a></li>
                
            <?php } else { ?>
                <li><a href="admin_petugas.php" class="active">Home</a></li>
                <li><a href="data_pengaduan.php">Data Pengaduan</a></li>
                <li><a href="data_masarakat.php">Data Masyarakat</a></li>
                <li class="dropdown"><a href="#"><span>Kelola User</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="user_masarakat.php">Akun Masyarakat</a></li>
                        <li><a href="user_admin.php">Akun Admin/Petugas</a></li>
                    </ul>
                </li>
            <?php } ?>
            
            <li><a href="logout.php" onclick="return confirm('Yakin ingin mengakhiri sesi Admin?')" class="text-danger fw-bold">Logout <i class="bi bi-box-arrow-right"></i></a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <span class="fw-bold text-dark"><i class="bi bi-shield-lock-fill text-warning"></i> Halo, <?= $_SESSION['nama_petugas'] ?></span>
      </div>

    </div>
  </header>

  <main class="main">

    <section id="hero" class="hero section">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h2 class="mb-3">Sistem Kelola Pengaduan</h2>
            <p>Selamat datang di halaman panel kontrol Dinas Lingkungan Hidup Kabupaten Minahasa. Gunakan navigasi di atas untuk mengelola laporan masyarakat.</p>
            
            <div class="mt-4">
                <span class="role-badge shadow">
                    <i class="bi bi-person-badge"></i> Akses: <?= $level ?>
                </span>
            </div>
          </div>
        </div>
      </div>

    </section></main>

  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="copyright text-center ">
        <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | <i class="bi bi-heart-fill" style="color: green;" aria-hidden="true"></i> by <strong>DESA</strong></p>
      </div>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <script src="assets/js/main.js"></script>

</body>
</html>