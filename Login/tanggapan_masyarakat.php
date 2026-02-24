<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum kembalikan ke index
if(!isset($_SESSION['nama'])){
    header("location: index.php");
    exit();
}

$idd = $_GET['id'];
$p = mysqli_query($conn, "SELECT * FROM tanggapan WHERE isi_laporan = '$idd'");
$data = mysqli_fetch_array($p);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Detail Tanggapan - DLH Minahasa</title>

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
    .tanggapan-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        padding: 40px;
        border-top: 5px solid #059669; /* Warna hijau DLH */
    }
    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .badge-success { background-color: #d1e7dd; color: #0f5132; }
    .badge-warning { background-color: #fff3cd; color: #664d03; }
    
    .tanggapan-box {
        background-color: #f8f9fa;
        border-left: 4px solid #0dcaf0;
        padding: 15px;
        border-radius: 0 5px 5px 0;
        font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="services-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="masarakat_admin.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">DLH Minahasa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="masarakat_admin.php">Home</a></li>
          <li><a href="pengaduan1.php" class="active">Pengaduan Saya</a></li>
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

    <div class="page-title light-background" data-aos="fade">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Tanggapan Petugas</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="masarakat_admin.php">Home</a></li>
            <li><a href="pengaduan1.php">Pengaduan Saya</a></li>
            <li class="current">Detail Tanggapan</li>
          </ol>
        </nav>
      </div>
    </div><section class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="tanggapan-card text-center">
                    <h3 class="mb-2">Detail Tanggapan Laporan</h3>
                    <p class="text-muted mb-4">Laporan terkait: <em>"<?= htmlspecialchars($idd) ?>"</em></p>

                    <?php if (!empty($data)) : ?>
                        
                        <div class="status-badge badge-success mb-3">
                            <i class="bi bi-check-circle-fill"></i> Telah Ditanggapi
                        </div>
                        <h6 class="text-muted mb-4">Tanggal: <?= date('d M Y', strtotime($data['tgl_tanggapan'])) ?></h6>

                        <div class="tanggapan-box text-start shadow-sm mb-4">
                            <textarea class="form-control" rows="6" readonly style="background-color: transparent; border: none; resize: none; font-size: 1.05rem;"><?= htmlspecialchars($data['tanggapan']) ?></textarea>
                        </div>

                    <?php else : ?>

                        <div class="status-badge badge-warning mb-4 py-3 px-4">
                            <i class="bi bi-clock-history fs-4 d-block mb-2"></i> 
                            Laporan Anda Sedang Dalam Antrean / Belum Ditanggapi
                        </div>
                        <p class="text-muted mb-4">Mohon bersabar, petugas kami akan segera memproses laporan Anda.</p>

                    <?php endif; ?>

                    <div class="mt-4">
                        <a class="btn btn-secondary px-4 py-2" href="pengaduan1.php">
                            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
                        </a>
                    </div>
                </div>

            </div>
        </div>

      </div>
    </section></main>

  <footer id="footer" class="footer light-background mt-auto">
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