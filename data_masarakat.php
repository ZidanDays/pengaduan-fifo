<?php
session_start();
error_reporting(0);
include 'koneksi.php';

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
  <title>Data Masyarakat - Admin</title>
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
            <li><a href="data_masarakat.php" class="active">Data Masyarakat</a></li>
          <?php } else { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan.php">Pengaduan</a></li>
            <li><a href="data_masarakat.php" class="active">Data Masyarakat</a></li>
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
        <h2>Data Masyarakat</h2>
        <p>Halaman kelola data kependudukan masyarakat desa.</p>
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

        <div class="row mb-4 align-items-center">
          <div class="col-md-6 mb-3 mb-md-0">
            <form action="" method="post" class="d-flex">
              <input type="text" name="cr" class="form-control me-2" placeholder="Cari NIK, Nama, atau Alamat..." value="<?php echo isset($_POST['cr']) ? $_POST['cr'] : ''; ?>">
              <button type="submit" name="cari" class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
            </form>
          </div>
          <div class="col-md-6 text-md-end">
            <a href="tambah_data_masarakat.php" class="btn btn-dark"><i class="bi bi-person-plus"></i> Tambah Data</a>
          </div>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th width="20%">Nama</th>
                <th width="15%">NIK</th>
                <th width="30%">Alamat</th>
                <th width="10%">RT/RW</th>
                <th width="20%" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $batas = 6;
              $halaman = @$_GET['halaman'];
              if(empty($halaman)){
                  $posisi = 0;
                  $halaman = 1;
              } else {
                  $posisi = ($halaman-1) * $batas;
              }
              $no = 1 + $posisi;
              
              $cari = isset($_POST['cr']) ? $_POST['cr'] : '';
              
              if ($cari != ''){
                  $query = mysqli_query($conn, "SELECT * FROM data_masyarakat WHERE nik LIKE '%".$cari."%' OR nama LIKE '%".$cari."%' OR alamat LIKE '%".$cari."%'");
              } else {
                  $query = mysqli_query($conn, "SELECT * FROM data_masyarakat LIMIT $posisi, $batas");
              }

              if (mysqli_num_rows($query) > 0){
                  while ($data = mysqli_fetch_array($query)){
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['nik']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['rt_rw']; ?></td>
                <td class="text-center">
                  <a class="btn btn-sm btn-success me-1 mb-1" href="edit_data_masarakat.php?id=<?php echo $data['id_masarakat']; ?>" title="Edit Data">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <a onClick="return confirm('Yakin Ingin Menghapus?')" class="btn btn-sm btn-danger mb-1" href="hapus_data_masarakat.php?idd=<?php echo $data['id_masarakat']; ?>" title="Hapus Data">
                    <i class="bi bi-trash"></i> Hapus
                  </a>
                </td>
              </tr>
              <?php 
                  } 
              } else {
                  echo '<tr><td colspan="6" class="text-center text-muted py-4">TIDAK ADA DATA MASYARAKAT</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>

        <?php
          $query2     = mysqli_query($conn, "SELECT * FROM data_masyarakat");
          $jmldata    = mysqli_num_rows($query2);
          $jmlhalaman = ceil($jmldata/$batas);
        ?>
        <nav aria-label="Page navigation" class="mt-4">
          <ul class="pagination justify-content-center">
            <?php for($i=1; $i<=$jmlhalaman; $i++) { 
                if ($i != $halaman){
                    echo "<li class='page-item'><a class='page-link' href='data_masarakat.php?halaman=$i'>$i</a></li>";
                } else {
                    echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                }
            } ?>
          </ul>
        </nav>

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