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
  <title>Data Pengaduan - Petugas</title>
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

    <section class="section">
      <div class="container text-center" data-aos="fade-up">
        <h2>Data Pengaduan</h2>
        <p>Halaman kelola pengaduan masyarakat oleh petugas.</p>
      </div>
    </section>

    <section class="section pt-0">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="bi bi-archive-fill fs-4 me-2 align-middle text-success"></i> 
            <span class="text-uppercase fw-bold">Arsip Data</span>
          </div>
          <div>
            <a href="data_pengaduan_petugas.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-list-task me-1"></i> Lihat ..</a>
          </div>
        </div>

        <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="bi bi-person-circle fs-4 me-2 align-middle text-primary"></i> 
            <span class="text-uppercase fw-bold"><?php echo $_SESSION['nama_petugas']; ?></span>
            <span class="badge bg-primary ms-2 text-uppercase"><?php echo $_SESSION['level']; ?></span>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <form action="" method="post" class="d-flex">
              <input type="text" name="cr" class="form-control me-2" placeholder="Cari NIK, Nama, Tanggal..." value="<?php echo isset($_POST['cr']) ? $_POST['cr'] : ''; ?>">
              <button type="submit" name="cari" class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
            </form>
          </div>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded">
          <table class="table table-bordered table-hover align-middle mb-0">
<thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pelapor</th>
                <th width="25%">Isi & Prioritas</th>
                <th width="10%">Foto</th>
                <th width="5%">Status</th>
                <th width="10%" class="text-center">Aksi</th>
                <th width="10%" class="text-center">Validasi</th>
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

              if ($cari != ''){
                  // Jika ada pencarian, tampilkan semua tanpa filter 'Proses' (Mencari arsip)
                  $query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE nama_pengadu LIKE '%".$cari."%' OR nik LIKE '%".$cari."%' OR tgl_pengaduan LIKE '%".$cari."%' OR status LIKE '%".$cari."%' ORDER BY FIELD(prioritas, 'Tinggi', 'Sedang', 'Rendah'), id_pengaduan ASC"); 
              } else {
                  // FILTER ACTIVE QUEUE & HYBRID FIFO
                  // Tampilkan HANYA status 'Proses', diurutkan berdasarkan Prioritas, baru FIFO (ID)
                  $query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = 'Proses' ORDER BY FIELD(prioritas, 'Tinggi', 'Sedang', 'Rendah'), id_pengaduan ASC LIMIT $posisi, $batas");
              }

              if (mysqli_num_rows($query) > 0){
                  while ($data = mysqli_fetch_array($query)){
                      
                      // // LOGIKA SLA (Service Level Agreement) - Warna Merah Jika Terlambat 2 Hari
                      // $tgl_masuk = strtotime($data['tgl_pengaduan']);
                      // $sekarang = time();
                      // $selisih_hari = floor(($sekarang - $tgl_masuk) / (60 * 60 * 24));
                      
                      // $peringatan_class = ($selisih_hari >= 2 && $data['status'] == 'Proses') ? 'table-danger' : '';

                      // LOGIKA SLA (MEMPERBAIKI ERROR 1970)
                      // Karena varchar berisi tanda kurung "2023-12-01 (14:30:00)", kita hapus tanda kurungnya agar bisa dibaca fungsi strtotime
                      $tgl_string_bersih = str_replace(['(', ')'], '', $data['tgl_pengaduan']);
                      $tgl_masuk = strtotime($tgl_string_bersih); 
                      
                      $sekarang = time();
                      $selisih_hari = floor(($sekarang - $tgl_masuk) / (60 * 60 * 24));
                      
                      $peringatan_class = ($selisih_hari >= 2 && $data['status'] == 'Proses') ? 'table-danger' : '';
              ?>
              <tr class="<?= $peringatan_class ?>">
                <td><?php echo $no++; ?></td>
                <td>
                    <?php echo date('d-m-Y', $tgl_masuk); ?>
                    <?php if($selisih_hari >= 2 && $data['status'] == 'Proses') { echo "<br><span class='badge bg-danger mt-1'><i class='bi bi-exclamation-triangle'></i> Terlambat!</span>"; } ?>
                </td>
                <td>
                    <strong><?php echo $data['nama_pengadu']; ?></strong><br>
                    <small class="text-muted">NIK: <?php echo $data['nik']; ?></small>
                </td>
                <td>
                    <?php 
                        if($data['prioritas'] == 'Tinggi') echo "<span class='badge bg-danger mb-1'>Prioritas Tinggi</span><br>";
                        elseif($data['prioritas'] == 'Sedang') echo "<span class='badge bg-warning text-dark mb-1'>Prioritas Sedang</span><br>";
                        else echo "<span class='badge bg-secondary mb-1'>Prioritas Rendah</span><br>";
                    ?>
                    <?php echo $data['isi_laporan']; ?>
                </td>
                <td>
                  <a href="Login/image/<?php echo $data['foto']; ?>" target="_blank" class="glightbox">
                    <img src="Login/image/<?php echo $data['foto']; ?>" height="55" class="rounded border" alt="Foto">
                  </a>
                </td>
                <td>
                    <span class="badge <?= ($data['status'] == 'Selesai') ? 'bg-success' : 'bg-warning text-dark' ?>"><?php echo $data['status']; ?></span>
                </td>
                <td class="text-center">
                  <form method="post" action="edit_selesai_ptgs.php?id=<?php echo $data['id_pengaduan']; ?>" class="mb-1">
                    <input type="hidden" name="id" value="<?php echo $data['id_pengaduan']; ?>">
                    <input type="hidden" name="status" value="Selesai">
                    <button type="submit" class="btn btn-sm btn-success mb-1 w-100" name="simpan"><i class="bi bi-check-circle"></i> Selesai</button>
                    <a onClick="return confirm('Yakin Ingin Menghapus?')" class="btn btn-sm btn-danger w-100" href="hapus_data_ptgs.php?idd=<?php echo $data['id_pengaduan']; ?>"><i class="bi bi-trash"></i> Hapus</a>
                  </form>
                </td>
                <td class="text-center">
                  <div class="dropdown mb-2">
                    <button class="btn btn-sm btn-dark w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-gear"></i> Set
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                      <li><a class="dropdown-item" href="tanggapan_ptgs.php?id=<?php echo $data['id_pengaduan']; ?>"><i class="bi bi-chat-dots me-2 text-primary"></i>Tanggapi</a></li>
                      <li><a class="dropdown-item" href="tanggapan_ptgs_cek.php?id=<?php echo $data['isi_laporan']; ?>"><i class="bi bi-eye me-2 text-info"></i>Lihat Tanggapan</a></li>
                    </ul>
                  </div>
                  <form method="post" action="data_masarakat_cek_ptgs.php">
                    <input type="hidden" name="cr" value="<?php echo $data['nik']; ?>" />
                    <button type="submit" class="btn btn-sm btn-outline-success w-100" name="cari"><i class="bi bi-person-check"></i> Cek NIK</button>
                  </form>
                </td>
              </tr>
              <?php 
                  } 
              } else {
                  echo '<tr><td colspan="8" class="text-center text-muted py-4">HORE! Antrean Bersih. Tidak ada laporan aktif saat ini.</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>

        <?php
          $query2     = mysqli_query($conn, "SELECT * FROM pengaduan");
          $jmldata    = mysqli_num_rows($query2);
          $jmlhalaman = ceil($jmldata/$batas);
        ?>
        <nav aria-label="Page navigation" class="mt-4">
          <ul class="pagination justify-content-center">
            <?php for($i=1; $i<=$jmlhalaman; $i++) { 
                if ($i != $halaman){
                    echo "<li class='page-item'><a class='page-link' href='data_pengaduan_petugas.php?halaman=$i'>$i</a></li>";
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