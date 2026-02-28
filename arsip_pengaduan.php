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
  <title>Arsip Pengaduan Selesai - Petugas</title>
  
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
            <li class="dropdown"><a href="#" class="active"><span>Pengaduan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="data_pengaduan_petugas.php">Antrean Aktif</a></li>
                <li><a href="arsip_pengaduan.php" class="active">Arsip Selesai</a></li>
              </ul>
            </li>
            <li><a href="data_masarakat_ptgs.php">Data Masyarakat</a></li>
          <?php } else { ?>
            <li><a href="admin_petugas.php">Home</a></li>
            <li><a href="data_pengaduan.php">Pengaduan</a></li>
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
  </header>

  <main class="main">

    <section class="section pb-0">
      <div class="container text-center" data-aos="fade-up">
        <h2>Arsip Pengaduan Selesai</h2>
        <p>Daftar riwayat pengaduan yang telah ditanggapi dan diselesaikan oleh petugas.</p>
      </div>
    </section>

    <section class="section pt-4">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="bi bi-archive-fill fs-4 me-2 align-middle text-success"></i> 
            <span class="text-uppercase fw-bold">Arsip Data</span>
          </div>
          <div>
            <a href="data_pengaduan_petugas.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-list-task me-1"></i> Lihat Antrean Aktif</a>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <form action="" method="post" class="d-flex">
              <input type="text" name="cr" class="form-control me-2" placeholder="Cari Arsip (NIK, Nama, Tanggal)..." value="<?php echo isset($_POST['cr']) ? $_POST['cr'] : ''; ?>">
              <button type="submit" name="cari" class="btn btn-success"><i class="bi bi-search"></i> Cari</button>
            </form>
          </div>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal Masuk</th>
                <th width="20%">Pelapor</th>
                <th width="30%">Isi Laporan</th>
                <th width="10%">Foto</th>
                <th width="10%">Status</th>
                <th width="13%" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $batas = 10;
              $halaman = @$_GET['halaman'];
              if(empty($halaman)){
                  $posisi = 0;
                  $halaman = 1;
              } else {
                  $posisi = ($halaman-1) * $batas;
              }

              $no = 1 + $posisi;
              $cari = isset($_POST['cr']) ? $_POST['cr'] : '';

              // Query untuk mengambil data yang STATUSNYA 'Selesai'
              if ($cari != ''){
                  $query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = 'Selesai' AND (nama_pengadu LIKE '%".$cari."%' OR nik LIKE '%".$cari."%' OR tgl_pengaduan LIKE '%".$cari."%') ORDER BY id_pengaduan DESC"); 
              } else {
                  $query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = 'Selesai' ORDER BY id_pengaduan DESC LIMIT $posisi, $batas");
              }

              if (mysqli_num_rows($query) > 0){
                  while ($data = mysqli_fetch_array($query)){
                      // Bersihkan tanggal dari format error 1970
                      $tgl_string_bersih = str_replace(['(', ')'], '', $data['tgl_pengaduan']);
                      $tgl_masuk = strtotime($tgl_string_bersih);
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d-m-Y', $tgl_masuk); ?></td>
                <td>
                    <strong><?php echo $data['nama_pengadu']; ?></strong><br>
                    <small class="text-muted">NIK: <?php echo $data['nik']; ?></small>
                </td>
                <td>
                    <?php 
                        if($data['prioritas'] == 'Tinggi') echo "<span class='badge bg-danger mb-1'>High</span> ";
                        elseif($data['prioritas'] == 'Sedang') echo "<span class='badge bg-warning text-dark mb-1'>Medium</span> ";
                    ?>
                    <?php echo $data['isi_laporan']; ?>
                </td>
                <td>
                  <a href="Login/image/<?php echo $data['foto']; ?>" target="_blank" class="glightbox">
                    <img src="Login/image/<?php echo $data['foto']; ?>" height="55" class="rounded border" alt="Foto">
                  </a>
                </td>
                <td>
                    <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                </td>
                <td class="text-center">
                  <a href="tanggapan_ptgs_cek.php?id=<?php echo $data['isi_laporan']; ?>" class="btn btn-sm btn-info text-white w-100 mb-1" title="Lihat Balasan">
                    <i class="bi bi-chat-text-fill me-1"></i> Detail
                  </a>
                  <a onClick="return confirm('Hapus arsip ini secara permanen?')" href="hapus_data_ptgs.php?idd=<?php echo $data['id_pengaduan']; ?>" class="btn btn-sm btn-danger w-100" title="Hapus Permanen">
                    <i class="bi bi-trash"></i> Hapus
                  </a>
                </td>
              </tr>
              <?php 
                  } 
              } else {
                  echo '<tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pengaduan yang selesai (Arsip Kosong).</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>

        <?php
          $q_page = ($cari != '') ? "SELECT * FROM pengaduan WHERE status = 'Selesai' AND (nama_pengadu LIKE '%$cari%')" : "SELECT * FROM pengaduan WHERE status = 'Selesai'";
          $query2     = mysqli_query($conn, $q_page);
          $jmldata    = mysqli_num_rows($query2);
          $jmlhalaman = ceil($jmldata/$batas);
        ?>
        <nav aria-label="Page navigation" class="mt-4">
          <ul class="pagination justify-content-center">
            <?php for($i=1; $i<=$jmlhalaman; $i++) { 
                if ($i != $halaman){
                    echo "<li class='page-item'><a class='page-link' href='arsip_pengaduan.php?halaman=$i'>$i</a></li>";
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

  <script src="assets/js/main.js"></script>t>

</body>
</html>