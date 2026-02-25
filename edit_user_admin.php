<?php
session_start();
error_reporting(0);
include 'koneksi.php';

$idd = $_GET['id'];
$p = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$idd'");
$data = mysqli_fetch_array($p);

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
  <title>Edit User Admin/Petugas - Admin</title>
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
            <li><a href="data_pengaduan_petugas.php">Pengaduan</a></li>
            <li><a href="data_masarakat.php">Data Masyarakat</a></li>
          <?php } else { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan.php">Pengaduan</a></li>
            <li><a href="data_masarakat.php">Data Masyarakat</a></li>
            <li class="dropdown"><a href="#" class="active"><span>Kelola User</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="user_masarakat.php">Masyarakat</a></li>
                <li><a href="user_admin.php" class="active">Admin Petugas</a></li>
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
        <h2>Edit User Admin / Petugas</h2>
        <p>Silakan ubah data akun pengelola sistem pada form di bawah ini.</p>
      </div>
    </section>

    <section class="section pt-4">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            
            <div class="card shadow-sm border-0">
              <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="card-title fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Form Edit User</h5>
              </div>
              <div class="card-body p-4">

                <?php
                // Proses Edit Data
                if (isset($_POST['simpan'])){
                    $id = $_POST['id'];
                    $nama = $_POST['nama'];
                    $user = $_POST['user'];
                    $pass = $_POST['pass'];
                    $tlp = $_POST['tlp'];
                    $level = $_POST['level'];
                    
                    $edit = mysqli_query($conn, "UPDATE petugas SET id_petugas='$id', nama_petugas='$nama', username='$user', password='$pass', tlp='$tlp', level='$level' WHERE id_petugas='$idd'");
                    
                    if($edit){
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong><i class='bi bi-check-circle'></i> Berhasil!</strong> Edit User Berhasil.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                        echo "<meta http-equiv='refresh' content='1;url=user_admin.php'>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong><i class='bi bi-exclamation-triangle'></i> Gagal!</strong> Edit User Gagal.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                    }
                }
                ?>

                <form method="post" action="">
                  <input type="hidden" name="id" value="<?php echo $data['id_petugas']; ?>">
                  
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap Petugas</label>
                    <input type="text" name="nama" class="form-control" required value="<?php echo $data['nama_petugas']; ?>">
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="user" class="form-control" required value="<?php echo $data['username']; ?>">
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="text" name="pass" class="form-control" required value="<?php echo $data['password']; ?>">
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">No Telepon</label>
                    <input type="text" name="tlp" class="form-control" required value="<?php echo $data['tlp']; ?>">
                  </div>
                  
                  <div class="mb-4">
                    <label class="form-label fw-semibold">Level Akses</label>
                    <select name="level" class="form-select" required>
                      <option value="Admin" <?php if(strtolower($data['level']) == 'admin') echo 'selected'; ?>>Admin</option>
                      <option value="Petugas" <?php if(strtolower($data['level']) == 'petugas') echo 'selected'; ?>>Petugas</option>
                    </select>
                  </div>
                  
                  <hr>
                  
                  <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-success" name="simpan"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                    <a class="btn btn-dark" href="user_admin.php"><i class="bi bi-box-arrow-left me-1"></i> Batal / Kembali</a>
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