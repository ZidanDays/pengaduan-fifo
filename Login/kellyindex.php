<?php
session_start();
include '../koneksi.php'; // Pastikan path koneksi disesuaikan karena berada di dalam folder Login

// Menangkap notifikasi login
$login_message = "";
if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    
    $data_user = mysqli_query($conn,"SELECT * FROM masyarakat WHERE username ='$user' AND password ='$pass'");
    
    if (mysqli_num_rows($data_user) > 0) {
        $r = mysqli_fetch_array($data_user);
        
        $_SESSION['nama'] = $r['nama'];
        $_SESSION['nik'] = $r['nik'];
        $_SESSION['tlp'] = $r['tlp'];
        
        $login_message = "<div class='alert alert-success text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Login Sukses! Mengalihkan...</div>";
        $login_message .= "<meta http-equiv='refresh' content='1;url=../masarakat_admin.php'>";
    } else {
        $login_message = "<div class='alert alert-danger text-center' style='position:absolute; top:80px; width:100%; z-index:9999;'>Login Gagal! Username atau Password salah.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login Masyarakat - DLH Minahasa</title>

  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  
  <link href="../assets/css/main.css" rel="stylesheet">

  <style>
    /* Styling khusus card login */
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        padding: 40px 30px;
        border-top: 5px solid #0dcaf0;
    }
    /* Memastikan background menutupi layar penuh */
    .login-section {
        min-height: 80vh;
        display: flex;
        align-items: center;
        background: url('../assets/img/hero-bg.jpg') center center;
        background-size: cover;
        position: relative;
    }
    .login-section::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.7); /* Overlay putih transparan */
    }
  </style>
</head>

<body class="contact-page"> <?= $login_message; ?>

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="../index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">DLH Minahasa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../registrasi.php">Registrasi</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <section class="login-section py-5">
      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 col-lg-5">
            
            <div class="login-card">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Login Masyarakat</h3>
                    <p class="text-muted">Silahkan masuk menggunakan akun Anda</p>
                </div>

                <form method="post" action="">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-person"></i> Username</label>
                        <input type="text" name="user" class="form-control form-control-lg" required="required" placeholder="Masukkan Username">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-lock"></i> Password</label>
                        <input type="password" name="pass" class="form-control form-control-lg" required="required" placeholder="Masukkan Password">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" name="login" class="btn btn-info btn-lg text-white fw-bold">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-1">Belum Punya Akun? <a href="../registrasi.php" class="text-info fw-bold text-decoration-none">Registrasi disini</a></p>
                    <a href="../index.php" class="text-secondary text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama</a>
                </div>
            </div>

          </div>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="copyright text-center ">
        <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | <i class="bi bi-heart-fill" style="color: green;" aria-hidden="true"></i> by <strong>DESA</strong></p>
      </div>
    </div>
  </footer>

  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/js/main.js"></script>

</body>
</html>