<?php
session_start();
include 'koneksi.php';

// Menangkap notifikasi registrasi
$register_message = "";
if (isset($_POST['simpan'])){
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $rtrw = $_POST['rtrw'];
    $tlp = $_POST['tlp'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $tambah = mysqli_query($conn, "INSERT INTO masyarakat(nik,nama,alamat,rt_rw,tlp,username,password) VALUES('$nik','$nama','$alamat','$rtrw','$tlp','$user','$pass')");
    
    if($tambah){
        $register_message = "<div class='alert alert-success text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Registrasi berhasil! Mengalihkan ke halaman Login...</div>";
        $register_message .= "<meta http-equiv='refresh' content='2;url=index.php'>";
    } else {
        $register_message = "<div class='alert alert-danger text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Registrasi Gagal! Silakan periksa kembali data Anda.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Registrasi Akun - Pengaduan Masyarakat DLH Minahasa</title>

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
  
  <style>
    /* Styling khusus card form agar terlihat elegan */
    .form-card {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-top: 4px solid #0dcaf0; /* Warna biru muda khas template */
    }
  </style>
</head>

<body class="contact-page"> <?= $register_message; ?>

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">DLH Minahasa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="registrasi.php" class="active">Registrasi Masyarakat</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <a href="mailto:lingkunganhidup@gmail.com" title="Email Kami"><i class="bi bi-envelope"></i></a>
        <a href="tel:+6285601198" title="Telepon Kami"><i class="bi bi-telephone"></i></a>
      </div>

    </div>
  </header>

  <main class="main">

    <div class="page-title light-background" data-aos="fade">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Pendaftaran Akun Baru</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Registrasi</li>
          </ol>
        </nav>
      </div>
    </div><section id="contact" class="contact section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="form-card">
              <div class="text-center mb-4">
                <h4>Silahkan Lengkapi Data Diri Anda</h4>
                <p class="text-muted">Gunakan NIK dan data asli untuk memudahkan petugas memverifikasi laporan Anda.</p>
              </div>

              <form method="post" action="">
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">NIK KTP <span class="text-danger">*</span></label>
                    <input type="text" name="nik" class="form-control" required="required" placeholder="16 Digit NIK" minlength="16" maxlength="16" onkeypress="return hanyaAngka(event)">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" required="required" placeholder="Nama sesuai KTP">
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="alamat" class="form-control" required="required" placeholder="Sebutkan Jalan/Desa/Kelurahan">
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">RT / RW <span class="text-danger">*</span></label>
                    <input type="text" name="rtrw" class="form-control" required="required" placeholder="Contoh: 001/002">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">No Telepon/WA <span class="text-danger">*</span></label>
                    <input type="text" name="tlp" class="form-control" required="required" placeholder="Contoh: 0812xxxxxx" maxlength="13" onkeypress="return hanyaAngka(event)">
                  </div>
                </div>

                <hr class="my-4">

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="user" class="form-control" required="required" placeholder="Buat Username">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="pass" class="form-control" required="required" placeholder="Buat Password">
                  </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                  <button type="submit" name="simpan" class="btn btn-success px-4 py-2"><i class="bi bi-person-check"></i> Daftar Sekarang</button>
                  <button type="reset" class="btn btn-danger px-4 py-2"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                </div>
                
              </form>
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

  <script>
    function hanyaAngka(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }
  </script>

</body>
</html>