<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum kembalikan ke index
if(!isset($_SESSION['nama'])){
    header("location: index.php");
    exit(); // Tambahkan exit agar eksekusi script langsung berhenti
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard Masyarakat - Pengaduan DLH Minahasa</title>

  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="../assets/css/main.css" rel="stylesheet">

  <style>
    /* Jarak antar tombol di hero section */
    .hero-buttons .btn-get-started {
        margin: 5px;
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="masarakat_admin.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">DLH Minahasa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="masarakat_admin.php" class="active">Home</a></li>
          <li><a href="pengaduan1.php">Pengaduan Saya</a></li>
          <li><a href="logout.php" onclick="return confirm('Yakin Ingin Logout?')" class="text-danger">Logout <i class="bi bi-box-arrow-right"></i></a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <span class="fw-bold" style="color: #059669;"><i class="bi bi-person-circle"></i> <?= $_SESSION['nama'] ?></span>
      </div>

    </div>
  </header>

  <main class="main">

    <section id="hero" class="hero section">

      <img src="../assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h2>Selamat Datang, <?= $_SESSION['nama'] ?>!</h2>
            <p>Di Sistem Pengaduan Masyarakat Dinas Lingkungan Hidup Minahasa. Silahkan sampaikan aspirasi dan keluh kesah Anda terkait lingkungan di wilayah Anda.</p>
            
            <div class="hero-buttons mt-4">
                <a href="pengaduan.php" class="btn-get-started"><i class="bi bi-pencil-square"></i> Buat Pengaduan</a>
                <a href="pengaduan1.php" class="btn-get-started" style="background-color: #0dcaf0; color:white;"><i class="bi bi-card-list"></i> Riwayat Pengaduan</a>
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

  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <script src="../assets/js/main.js"></script>

</body>
</html>