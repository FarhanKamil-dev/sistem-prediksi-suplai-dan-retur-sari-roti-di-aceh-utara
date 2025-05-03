<?php
include_once("koneksi.php");

$kode_retur = "";
$kode_toko = ""; // Ubah nama variabel sesuai dengan perubahan yang telah Anda lakukan
$nama_toko = "";
$kode_produk = ""; // Ubah nama variabel sesuai dengan perubahan yang telah Anda lakukan
$bulan_tahun = "";
$data_aktual = "";
$pesan_error = array();

if (isset($_POST["submit"])) {
    $kode_retur = htmlentities(strip_tags(trim($_POST['kode_retur'])));
    $kode_toko = htmlentities(strip_tags(trim($_POST['kode_toko']))); // Ubah nama variabel sesuai dengan perubahan yang telah Anda lakukan
    $nama_toko = htmlentities(strip_tags(trim($_POST['nama_toko'])));
    $kode_produk = htmlentities(strip_tags(trim($_POST['kode_produk']))); // Ubah nama variabel sesuai dengan perubahan yang telah Anda lakukan
    $bulan_tahun = htmlentities(strip_tags(trim($_POST['bulan_tahun'])));
    $data_aktual = htmlentities(strip_tags(trim($_POST['data_aktual'])));

    $pesan_error = array();

    if (empty($kode_retur)) {
        $pesan_error[] = "Kode retur belum diisi!";
    }

    if (empty($kode_toko)) {
        $pesan_error[] = "Kode toko belum diisi!";
    }
    if (empty($nama_toko)) {
        $pesan_error[] = "Nama toko belum diisi!";
    }

    if (empty($kode_produk)) {
        $pesan_error[] = "Kode produk belum diisi!";
    }

    if (empty($bulan_tahun)) {
        $pesan_error[] = "Bulan - Tahun belum diisi!";
    }

    if (empty($data_aktual)) {
        $pesan_error[] = "Data aktual belum diisi!";
    }

    if (!$pesan_error) {
        $kode_retur = mysqli_real_escape_string($koneksi, $kode_retur);
        $kode_toko = mysqli_real_escape_string($koneksi, $kode_toko);
        $nama_toko = mysqli_real_escape_string($koneksi, $nama_toko);
        $kode_produk = mysqli_real_escape_string($koneksi, $kode_produk);
        $bulan_tahun = mysqli_real_escape_string($koneksi, $bulan_tahun);
        $data_aktual = mysqli_real_escape_string($koneksi, $data_aktual);

        $querytambah = "INSERT INTO tb_retur1 (kode_retur, kode_toko, nama_toko, kode_produk, bln_thn, jumlah_retur) 
        VALUES ('$kode_retur', '$kode_toko', '$nama_toko', '$kode_produk', '$bulan_tahun', '$data_aktual')";

        $resultquery = mysqli_query($koneksi, $querytambah);

        if ($resultquery) {
            $pesan_sukses = "Data retur berhasil ditambahkan!";
            $pesan_sukses = urlencode($pesan_sukses);
            header("Location: data_retur.php?pesan_sukses={$pesan_sukses}");
            exit();
        } else {
            die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
        }
    }

    mysqli_free_result($resultquery);
    mysqli_close($koneksi);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Retur</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once 'sidebar.php'; ?>

    <div class="content-container">
        <div class="container-fluid">
            <div class="jumbotron">
                <h2 style="margin-bottom: 25px;">Tambah Data Retur</h2>
                <?php
                if ($pesan_error !== "") {
                    foreach ($pesan_error as $per) {
                        echo "<div class='alert alert-danger alert-dismissible'>
                        <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Gagal!</strong> ".$per.
                        "</div>";
                    }
                }
                ?>
                <form action="tambah_retur.php" method="post" name="form1">
                    <div class="form-group">
                        <label for="kode_retur">Kode Retur</label>
                        <input class="form-control" type="text" name="kode_retur" required>
                    </div>
                    <div class="form-group">
                    <label for="kode_toko">Kode Toko</label>
                    <select class="form-control" name="kode_toko" required>
                        <?php
                        $query_toko = "SELECT kode_toko, nama_toko FROM tb_daftar_toko";
                        $result_toko = mysqli_query($koneksi, $query_toko);

                        while ($row = mysqli_fetch_assoc($result_toko)) {
                            echo "<option value='" . $row['kode_toko'] . "'>" . $row['kode_toko'] . " - " . $row['nama_toko'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                    <div class="form-group">
                        <label for="nama_toko">Nama Toko</label>
                        <select class="form-control" name="nama_toko" required>
                            <?php
                            $query_toko = "SELECT kode_toko, nama_toko FROM tb_daftar_toko";
                            $result_toko = mysqli_query($koneksi, $query_toko);

                            while ($row = mysqli_fetch_assoc($result_toko)) {
                                echo "<option value='" . $row['nama_toko'] . "'>" . $row['nama_toko'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="kode_produk">Kode Produk</label>
                    <select class="form-control" name="kode_produk" required>
                        <?php
                        $query_produk = "SELECT kode_produk, nama_produk FROM tb_produk";
                        $result_produk = mysqli_query($koneksi, $query_produk);

                        while ($row = mysqli_fetch_assoc($result_produk)) {
                            echo "<option value='" . $row['kode_produk'] . "'>" . $row['nama_produk'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                    <div class="form-group">
                        <label for="bulan_tahun">Bulan - Tahun</label>
                        <input class="form-control" type="date" name="bulan_tahun" required>
                    </div>
                    <div class="form-group">
                        <label for="data_aktual">Data Aktual</label>
                        <input class="form-control" type="text" name="data_aktual" required>
                    </div>
                    <div style="display: flex;">
                        <div style="margin-top:20px;">
                            <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                        </div>
                        <div style="margin: 20px 0px 0px 20px;">
                            <a class="btn btn-danger" href="data_retur.php">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</body>
</html>
