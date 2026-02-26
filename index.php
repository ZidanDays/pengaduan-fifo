<?php
session_start();
include 'koneksi.php';

// Menangkap notifikasi login
$login_message = "";
if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $data_user = mysqli_query($conn, "SELECT * FROM petugas WHERE username ='$user' AND password ='$pass'");
    $r = mysqli_fetch_array($data_user);
    
    if($r) { // Memastikan data ditemukan
        $username = $r['username'];
        $password = $r['password'];
        $nama_user = $r['nama_petugas'];
        $nik = $r['level'];
        
        if ($user == $username && $pass == $password) {
            $_SESSION['nama_petugas'] = $nama_user;
            $_SESSION['level'] = $nik;
            $login_message = "<div class='alert alert-success text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Login Sukses! Mengalihkan...</div>";
            $login_message .= "<meta http-equiv='refresh' content='1;url=admin_petugas.php'>";
        } else {
            $login_message = "<div class='alert alert-danger text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Login Gagal! Password salah.</div>";
            $login_message .= "<meta http-equiv='refresh' content='1;url=index.php'>";
        }
    } else {
        $login_message = "<div class='alert alert-danger text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Login Gagal! Akun tidak ditemukan.</div>";
        $login_message .= "<meta http-equiv='refresh' content='1;url=index.php'>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Beranda - Pengaduan Masyarakat DLH Minahasa</title>
  <meta name="description" content="Sistem Pengaduan Masyarakat Dinas Lingkungan Hidup Kabupaten Minahasa">
  <meta name="keywords" content="Pengaduan, Masyarakat, DLH, Minahasa, Lingkungan Hidup">

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
    /* CSS untuk tombol WhatsApp Melayang */
    .floatwa {
        position: fixed;
        bottom: 0px;
        right: 0px;
        background-color: #ffffff;
        width: 100%;
        z-index: 1000;
        padding: 5px;
        box-shadow: 0px -2px 10px #c0c0c0;
        text-align: center;
    }
    .tombolwa {
        border: 1px #56aa71 solid;
        background-color: #2f7e49;
        width: 90%;
        max-width: 400px;
        padding: 8px;
        margin: auto;
        border-radius: 5px;
        color: white;
        font-weight: bold;
    }
    .floatwa a {
        text-decoration: none;
    }
    .floatwa a:hover .tombolwa {
        background-color: #246339;
    }
    /* Jarak antar tombol di hero section */
    .hero-buttons .btn-get-started {
        margin: 5px;
    }
  </style>
</head>

<body class="index-page">

  <?= $login_message; ?>

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- <h1 class="sitename">DLH Minahasa</h1> -->
         <img src="image/logo2.png" alt="" class="logo-responsive" style="max-width: 100%; height: auto; display: block;">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginAdminModal">Login Admin/Petugas</a></li>
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

    <section id="hero" class="hero section">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h2>Sistem Pengaduan Masyarakat</h2>
            <p>Selamat datang di website Pengaduan Masyarakat Dinas Lingkungan Hidup Minahasa. Silahkan Daftar dan Login dengan akun Anda untuk membuat laporan.</p>
            <div class="hero-buttons mt-4">
                <a href="registrasi.php" class="btn-get-started"><i class="bi bi-person-plus-fill"></i> Daftar Disini</a>
                <a href="Login/index.php" class="btn-get-started" style="background-color: #0dcaf0; color:white;"><i class="bi bi-box-arrow-in-right"></i> Login Masyarakat</a>
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
  <br>

  <div class="modal fade" id="loginAdminModal" tabindex="-1" aria-labelledby="loginAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginAdminModalLabel"><i class="bi bi-shield-lock-fill"></i> Login Khusus Admin/Petugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action="">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="user" required="required" placeholder="Masukkan Username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="pass" required="required" placeholder="Masukkan Password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" name="login" class="btn btn-success"><i class="bi bi-box-arrow-in-right"></i> Login</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="floatwa">
      <a href="https://api.whatsapp.com/send?phone=62895357219911&amp;text=Halo%20ADMIN,%20Saya%20mau%20Lapor,%20saya%20lupa%20akun" target="_blank">
          <div class="tombolwa"><i class="bi bi-whatsapp"></i> LUPA PASSWORD? SILAHKAN LAPOR DISINI!</div>
      </a>
  </div> 

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