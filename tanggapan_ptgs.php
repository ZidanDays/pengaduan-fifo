<?php
session_start();
error_reporting(0);
include 'koneksi.php';

$idd = $_GET['id'];
$p = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan = '$idd'");
$data = mysqli_fetch_array($p);

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// Cek sesi login
if(!isset($_SESSION['nama_petugas'])){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Beri Tanggapan - Petugas</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="admin_petugas.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">DESA</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <?php if ($_SESSION['level'] == 'petugas') { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan_petugas.php" class="active">Pengaduan</a></li>
            <li><a href="data_masarakat_ptgs.php">Data Masyarakat</a></li>
          <?php } else { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan.php" class="active">Pengaduan</a></li>
            <li><a href="data_masarakat.php">Data Masyarakat</a></li>
            <li class="dropdown"><a href="#"><span>Kelola User</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="user_masarakat.php">Masyarakat</a></li>
                <li><a href="user_admin.php">Admin Petugas</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <a href="logout.php" onclick="return confirm('Yakin Ingin Logout?')" class="text-danger fw-bold" style="font-size: 16px;">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>

    </div>
  </header><main class="main">

    <section class="section pb-0">
      <div class="container text-center" data-aos="fade-up">
        <h2>Tindak Lanjut & Tanggapan</h2>
        <p>Berikan balasan atau status penanganan atas laporan yang diajukan masyarakat.</p>
      </div>
    </section>

    <section class="section pt-4">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="bi bi-person-circle fs-4 me-2 align-middle text-primary"></i> 
            <span class="text-uppercase fw-bold"><?php echo $_SESSION['nama_petugas']; ?></span>
            <span class="badge bg-primary ms-2 text-uppercase"><?php echo $_SESSION['level']; ?></span>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            
            <div class="card shadow-sm border-0 border-top border-success border-4">
              <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="card-title fw-bold text-success"><i class="bi bi-reply-fill me-2"></i>Form Tanggapan Petugas</h5>
              </div>
              <div class="card-body p-4 p-md-5">

                <?php
                if (isset($_POST['simpan'])){
                    $idp = $_POST['idp'];
                    $tgl = $_POST['tgl'];
                    $isi = $_POST['isi'];
                    $tgp = $_POST['tgp'];
                    // Catatan: Jika ada fitur multi-admin, value 'adm' bisa diganti dengan id_petugas dari Session
                    $adm = $_POST['adm']; 
                    
                    $tambah = mysqli_query($conn, "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, isi_laporan, tanggapan, id_petugas) VALUES ('$idp', '$tgl', '$isi', '$tgp', '$adm')");
                    
                    if($tambah){
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong><i class='bi bi-check-circle'></i> Berhasil Ditanggapi!</strong> Laporan telah dibalas.
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                              </div>";
                        // Arahkan kembali ke data pengaduan petugas
                        echo "<meta http-equiv='refresh' content='1;url=data_pengaduan_petugas.php'>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong><i class='bi bi-exclamation-triangle'></i> Gagal Menanggapi!</strong> Silakan coba lagi.
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                              </div>";
                    }
                }
                ?>

                <form method="post" action="">
                  <input type="hidden" name="idp" value="<?= $data['id_pengaduan']; ?>">
                  <input type="hidden" name="isi" value="<?= $data['isi_laporan']; ?>">
                  <input type="hidden" name="adm" value="1">

                  <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Isi Laporan Warga:</label>
                    <textarea class="form-control bg-light text-muted border-0 shadow-sm" rows="3" readonly><?= $data['isi_laporan']; ?></textarea>
                  </div>

                  <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Tanggal Tanggapan:</label>
                    <input type="text" name="tgl" class="form-control bg-light text-muted border-0 shadow-sm" required value="<?= date('Y-m-d H:i:s'); ?>" readonly>
                  </div>

                  <div class="mb-4">
                    <label class="form-label fw-bold text-success">Balasan / Tindak Lanjut Petugas:</label>
                    <textarea name="tgp" class="form-control shadow-sm" rows="6" placeholder="Tuliskan hasil penanganan atau jawaban atas keluhan warga di sini..." required></textarea>
                  </div>
                  
                  <hr class="mb-4">
                  
                  <div class="d-flex justify-content-between mt-4">
                    <a class="btn btn-dark px-4" href="data_pengaduan_petugas.php"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                    <div>
                      <button type="reset" class="btn btn-secondary me-2"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                      <button type="submit" class="btn btn-success px-4 fw-bold shadow" name="simpan"><i class="bi bi-send-check me-1"></i> Tanggapi</button>
                    </div>
                  </div>

                </form>

              </div>
            </div>

          </div>
        </div>

      </div>
    </section>

  </main>

  <footer id="footer" class="footer light-background mt-auto">
    <div class="container">
      <div class="copyright text-center ">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">DESA</strong> <span>All Rights Reserved</span></p>
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a>
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