<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum kembalikan ke index
if(!isset($_SESSION['nama'])){
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pengaduan Saya - DLH Minahasa</title>

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
    .table-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        padding: 20px;
        border-top: 4px solid #0dcaf0;
    }
    /* Mengatur agar foto di dalam tabel terlihat proporsional */
    .table img {
        border-radius: 4px;
        object-fit: cover;
    }
  </style>
</head>

<body class="services-page"> <header id="header" class="header d-flex align-items-center light-background sticky-top">
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
        <h1 class="mb-2 mb-lg-0">Riwayat Pengaduan Saya</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="masarakat_admin.php">Home</a></li>
            <li class="current">Pengaduan Saya</li>
          </ol>
        </nav>
      </div>
    </div><section class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="table-container">
            <h4 class="mb-4"><i class="bi bi-card-list"></i> Daftar Laporan Anda</h4>
            
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
<thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Laporan & Prioritas</th>
                            <th>Foto</th>
                            <th>Status & Antrean</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;      
                        $nik = $_SESSION['nik'];
                        $query = mysqli_query($conn,"SELECT * FROM pengaduan WHERE nik = '$nik' ORDER BY id_pengaduan DESC");
                        
                        if (mysqli_num_rows($query) > 0){
                            while ($data = mysqli_fetch_array($query)){
                                
                                // KALKULASI POSISI ANTREAN JIKA MASIH 'PROSES'
                                $teks_antrean = "";
                                if($data['status'] == 'Proses') {
                                    $id_ini = $data['id_pengaduan'];
                                    $prio_ini = $data['prioritas'];
                                    
                                    // Hitung laporan dengan prioritas lebih tinggi ATAU (prioritas sama tapi ID lebih kecil/masuk duluan)
                                    $cek_antrean = mysqli_query($conn, "
                                        SELECT COUNT(*) AS posisi FROM pengaduan 
                                        WHERE status = 'Proses' 
                                        AND (
                                            FIELD(prioritas, 'Tinggi', 'Sedang', 'Rendah') < FIELD('$prio_ini', 'Tinggi', 'Sedang', 'Rendah')
                                            OR (prioritas = '$prio_ini' AND id_pengaduan <= $id_ini)
                                        )
                                    ");
                                    $data_antrean = mysqli_fetch_assoc($cek_antrean);
                                    $urutan = $data_antrean['posisi'];
                                    $teks_antrean = "<div class='mt-2 badge bg-primary bg-opacity-10 text-primary border border-primary'><i class='bi bi-hourglass-split'></i> Antrean ke-$urutan</div>";
                                }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y', strtotime(str_replace(['(', ')'], '', $data['tgl_pengaduan']))) ?></td>
                            <td class="text-start" style="max-width: 250px;">
                                <?php if($data['prioritas'] == 'Tinggi') echo "<span class='badge bg-danger mb-1'>Tinggi</span><br>"; ?>
                                <?= $data['isi_laporan'] ?>
                            </td>
                            <td>
                                <a href="image/<?= $data['foto']; ?>" target="_blank">
                                    <img src="image/<?= $data['foto'] ?>" height="55px" alt="Bukti">
                                </a>
                            </td>
                            <td>
                                <span class="badge <?= ($data['status'] == 'Selesai') ? 'bg-success' : 'bg-warning text-dark' ?> fs-6"><?= $data['status'] ?></span>
                                <?= $teks_antrean ?>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-success" href="tanggapan_masyarakat.php?id=<?= $data['id_pengaduan'] ?>">
                                    <i class="bi bi-eye"></i> Tanggapan
                                </a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                            echo '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada laporan yang diajukan.</td></tr>';
                        } 
                        ?>
                    </tbody>
                </table>
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