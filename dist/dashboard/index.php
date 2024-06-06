<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpus</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<script>
    $(document).ready(function() {
        $('title').text('Dashboard');
    });
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">PERPUSTAKAN</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data aktifitas Perpus</li>
        </ol>

        <?php if ($_SESSION["level"] == 'Karyawan' || $_SESSION["level"] == 'karyawan'): ?>
        <div class="row">
            <?php
            include '../config/database.php';
            $hasil = mysqli_query($kon, "SELECT kode_peminjaman FROM detail_peminjaman");
            $total_peminjaman = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Total Peminjaman</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $total_peminjaman; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-grip-horizontal fa-2x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $hasil = mysqli_query($kon, "SELECT kode_anggota FROM anggota");
            $jumlah_anggota = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Jumlah Anggota</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $jumlah_anggota; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $hasil = mysqli_query($kon, "SELECT kode_pustaka FROM pustaka");
            $jumlah_pustaka = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Jumlah Pustaka</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $jumlah_pustaka; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT SUM(denda) as total_denda FROM detail_peminjaman";
            $hasil = mysqli_query($kon, $sql);
            $data = mysqli_fetch_array($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Total Denda</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800">Rp. <?php echo number_format($data['total_denda'], 0, ',', '.'); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($_SESSION["level"] == 'Anggota' || $_SESSION["level"] == 'anggota'): ?>
        <div class="row">
            <?php
            $kode_anggota = $_SESSION["kode_pengguna"];
            include '../config/database.php';
            $sql = "SELECT p.kode_peminjaman FROM detail_peminjaman d
                    INNER JOIN peminjaman p ON p.kode_peminjaman = d.kode_peminjaman
                    WHERE p.kode_anggota = '$kode_anggota' AND d.status = '0'";
            $hasil = mysqli_query($kon, $sql);
            $belum_diambil = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Belum diambil</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $belum_diambil; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-shopping-bag fa-3x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT p.kode_peminjaman FROM detail_peminjaman d
                    INNER JOIN peminjaman p ON p.kode_peminjaman = d.kode_peminjaman
                    WHERE p.kode_anggota = '$kode_anggota' AND d.status = '1'";
            $hasil = mysqli_query($kon, $sql);
            $sedang_dipinjam = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Sedang Dipinjam</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $sedang_dipinjam; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-hourglass-start fa-3x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT p.kode_peminjaman FROM detail_peminjaman d
                    INNER JOIN peminjaman p ON p.kode_peminjaman = d.kode_peminjaman
                    WHERE p.kode_anggota = '$kode_anggota' AND d.status = '2'";
            $hasil = mysqli_query($kon, $sql);
            $telah_selesai = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Telah Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $telah_selesai; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-check-square fa-3x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT p.kode_peminjaman FROM detail_peminjaman d
                    INNER JOIN peminjaman p ON p.kode_peminjaman = d.kode_peminjaman
                    WHERE p.kode_anggota = '$kode_anggota'";
            $hasil = mysqli_query($kon, $sql);
            $total_peminjaman = mysqli_num_rows($hasil);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs text-white text-uppercase mb-1">Total</div>
                                <div class="h5 mb-0 font-weight-bold text-dark-800"><?php echo $total_peminjaman; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-bars fa-3x text-dark-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>


</body>
</html>
