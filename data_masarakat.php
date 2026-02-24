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

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <header id="header" class="fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <h1 class="logo me-auto me-lg-0"><a href="admin_petugas.php">DESA</a></h1>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <?php if ($_SESSION['level'] == 'petugas') { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan_petugas.php">Pengaduan</a></li>
            <li><a class="active" href="data_masarakat.php">Data Masyarakat</a></li>
          <?php } else { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan.php">Pengaduan</a></li>
            <li><a class="active" href="data_masarakat.php">Data Masyarakat</a></li>
            <li class="dropdown"><a href="#"><span>Kelola User</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="user_masarakat.php">Masyarakat</a></li>
                <li><a href="user_admin.php">Admin Petugas</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><div class="header-social-links">
        <a href="logout.php" onclick="return confirm('Yakin Ingin Logout?')" class="text-danger fw-bold" title="Logout">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>

    </div>
  </header><main id="main">

    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Data Masyarakat</h2>
          <ol>
            <li><a href="admin_petugas.php">Home</a></li>
            <li>Data Masyarakat</li>
          </ol>
        </div>
      </div>
    </section><section class="inner-page">
      <div class="container" data-aos="fade-up">

        <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="bi bi-person-circle fs-4 me-2 align-middle"></i> 
            <span class="text-uppercase fw-bold"><?php echo $_SESSION['nama_petugas']; ?></span>
            <span class="badge bg-primary ms-2 text-uppercase"><?php echo $_SESSION['level']; ?></span>
          </div>
        </div>

        <div class="row mb-4 align-items-center">
          <div class="col-md-6">
            <form action="" method="post" class="d-flex">
              <input type="text" name="cr" class="form-control me-2" placeholder="Cari NIK, Nama, atau Alamat..." value="<?php echo isset($_POST['cr']) ? $_POST['cr'] : ''; ?>">
              <button type="submit" name="cari" class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
            </form>
          </div>
          <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="tambah_data_masarakat.php" class="btn btn-dark"><i class="bi bi-person-plus"></i> Tambah Data</a>
          </div>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Alamat</th>
                <th>RT/RW</th>
                <th class="text-center">Aksi</th>
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
                  <a class="btn btn-sm btn-success mb-1" href="edit_data_masarakat.php?id=<?php echo $data['id_masarakat']; ?>" title="Edit Data">
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

  </main><footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <?php echo date('Y'); ?> <strong><span>DESA</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>

</body>
</html>