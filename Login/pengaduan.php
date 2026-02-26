<?php
session_start();
error_reporting(0);
include 'koneksi.php';

// Cek sesi login masyarakat
if(!isset($_SESSION['nama'])){
    header("location: index.php");
    exit();
} else {
    date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Buat Pengaduan - Pengaduan Desa</title>
  <meta name="description" content="Web Pelaporan Pengaduan Masyarakat">

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
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="masarakat_admin.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Pengaduan Desa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="masarakat_admin.php">Home</a></li>
          <li><a href="pengaduan.php" class="active">Buat Laporan</a></li>
          <li><a href="pengaduan1.php">Pengaduan Saya</a></li>
          <li><a href="logout.php" onclick="return confirm('Yakin Ingin Logout?')">Logout</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links d-none d-md-block">
        <span class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold border-2">
          <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['nama']); ?>
        </span>
      </div>

    </div>
  </header><main class="main">

    <section id="form-pengaduan" class="contact section pt-5">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="section-title text-center mb-4">
          <h2>Formulir Pengaduan</h2>
          <p>Silakan isi detail kejadian pada form di bawah ini. Harap tentukan prioritas laporan dengan bijak.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            
            <?php
            // Logika Proses PHP
            if (isset($_POST['simpan'])){
                $tgl = $_POST['tgl'];
                $nama = $_POST['nama'];
                $nik = $_POST['nik'];
                $laporan = $_POST['laporan'];
                $prioritas = $_POST['prioritas']; // Menangkap Dropdown Prioritas
                $tlp = $_POST['tlp'];
                $st = $_POST['st'];
                
                // --- LOGIKA ANTI-SPAM ---
                $cek_spam = mysqli_query($conn, "SELECT COUNT(id_pengaduan) AS total_aktif FROM pengaduan WHERE nik = '$nik' AND status = 'Proses'");
                $data_spam = mysqli_fetch_assoc($cek_spam);
                
                if ($data_spam['total_aktif'] >= 3) {
                    // Tolak eksekusi jika sudah ada 3 laporan aktif
                    echo "<div class='alert alert-danger alert-dismissible fade show text-center shadow-sm'>
                            <i class='bi bi-shield-lock-fill fs-3 d-block mb-2 text-danger'></i>
                            <strong>Pengiriman Laporan Ditangguhkan!</strong><br> 
                            Anda masih memiliki <strong>3 laporan</strong> yang sedang dalam antrean proses petugas.<br>Harap tunggu hingga laporan sebelumnya diselesaikan untuk mencegah penumpukan data.
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                          </div>";
                } else {
                    // --- JIKA LOLOS, LANJUTKAN PROSES UPLOAD & INSERT ---
                    $gambar = $_FILES['gambar']['name'];
                    $tmp_file = $_FILES['gambar']['tmp_name'];
                    
                    // Path penyimpanan gambar
                    $path = "image/" . $gambar;
                    
                    if(move_uploaded_file($tmp_file, $path)){
                        // Insert query (sesuaikan dengan nama variabel post Anda)
                        $query_insert = "INSERT INTO pengaduan (tgl_pengaduan, nama_pengadu, nik, isi_laporan, tlp, foto, status, prioritas) 
                                         VALUES ('$tgl', '$nama', '$nik', '$laporan', '$tlp', '$gambar', '$st', '$prioritas')";
                                         
                        $tambah = mysqli_query($conn, $query_insert);
                        
                        if($tambah){
                            echo "<div class='alert alert-success text-center fw-bold shadow-sm'><i class='bi bi-check-circle-fill me-2'></i>Laporan Berhasil Masuk ke Antrean!</div>";
                            echo "<meta http-equiv='refresh' content='1.5;url=pengaduan1.php'>";
                        } else {
                            echo "<div class='alert alert-danger text-center shadow-sm'><i class='bi bi-x-circle-fill me-2'></i>Gagal Menyimpan Pengaduan: " . mysqli_error($conn) . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger text-center shadow-sm'><i class='bi bi-x-circle-fill me-2'></i>Gagal mengunggah foto. Pastikan format foto benar dan folder penyimpanan 'image' tersedia.</div>";
                    }
                }
            }
            ?>

            <div class="card shadow border-0 border-top border-primary border-4 mt-2">
              <div class="card-body p-4 p-md-5">
                <form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="st" value="Proses">
                  
                  <input type="hidden" name="tgl" value="<?php echo date('Y-m-d (H:i:s)'); ?>">

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold text-secondary">Nama Pelapor</label>
                      <input type="text" name="nama" class="form-control bg-light" required value="<?php echo htmlspecialchars($_SESSION['nama']); ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold text-secondary">NIK</label>
                      <input type="text" name="nik" class="form-control bg-light" required value="<?php echo htmlspecialchars($_SESSION['nik']); ?>" readonly>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="tlp" class="form-control bg-light" required value="<?php echo htmlspecialchars($_SESSION['tlp']); ?>" readonly>
                  </div>

                  <div class="mb-4 bg-light p-3 rounded border border-primary border-opacity-25">
                    <label class="form-label fw-bold text-primary"><i class="bi bi-exclamation-triangle-fill me-1"></i> Tingkat Urgensi Laporan</label>
                    <select name="prioritas" class="form-select border-primary shadow-sm" required>
                      <option value="" disabled selected>-- Pilih Skala Prioritas --</option>
                      <option value="Rendah">Rendah (Contoh: Rumput panjang, lampu jalan redup)</option>
                      <option value="Sedang">Sedang (Contoh: Jalan berlubang, selokan tersumbat)</option>
                      <option value="Tinggi">Tinggi / Darurat (Contoh: Kebakaran, Jembatan putus, Longsor)</option>
                    </select>
                    <small class="text-muted d-block mt-2"><i class="bi bi-info-circle"></i> Memilih tingkat darurat secara jujur membantu petugas menolong kondisi yang mendesak lebih dulu.</small>
                  </div>

                  <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Detail Kejadian / Kronologi</label>
                    <textarea name="laporan" class="form-control shadow-sm border-secondary border-opacity-50" rows="5" required placeholder="Tuliskan keluhan Anda secara jelas beserta lokasinya..."></textarea>
                  </div>

                  <div class="mb-5">
                    <label class="form-label fw-bold text-dark">Unggah Foto Bukti Kejadian</label>
                    <input type="file" name="gambar" class="form-control shadow-sm border-secondary border-opacity-50" accept="image/*" required>
                    <small class="text-muted">Format yang disarankan: JPG, JPEG, PNG.</small>
                  </div>

                  <hr class="mb-4 text-secondary">

                  <div class="d-flex gap-2 justify-content-end">
                    <button type="reset" class="btn btn-secondary px-4"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm" name="simpan"><i class="bi bi-send-fill me-1"></i> Kirim Pengaduan</button>
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
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Pengaduan Desa</strong> <span>All Rights Reserved</span></p>
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
<?php } ?>