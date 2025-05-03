<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

include_once("koneksi.php");

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Edit") {

        $kode_retur_edit = htmlentities(strip_tags(trim($_POST["kode_retur"])));
        $kode_retur_edit = mysqli_real_escape_string($koneksi, $kode_retur_edit);

        $querytampilkode_retur = "SELECT * FROM tb_retur1 WHERE kode_retur ='$kode_retur_edit'";
        $resultquery = mysqli_query($koneksi, $querytampilkode_retur);

        if (!$resultquery) {
            die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
        }

        $data = mysqli_fetch_assoc($resultquery);

        $kode_retur = $data["kode_retur"];
        $kode_toko = $data["kode_toko"];
        $nama_toko = $data["nama_toko"];
        $kode_produk = $data["kode_produk"];
        $bulan_tahun = $data["bln_thn"];
        $data_aktual = $data["jumlah_retur"];

        mysqli_free_result($resultquery);

    } else if ($_POST["submit"] == "Update Data") {

        $kode_retur = htmlentities(strip_tags(trim($_POST['kode_retur'])));
        $kode_toko = htmlentities(strip_tags(trim($_POST['kode_toko'])));
        $nama_toko = htmlentities(strip_tags(trim($_POST['nama_toko'])));
        $kode_produk = htmlentities(strip_tags(trim($_POST['kode_produk'])));
        $bulan_tahun = htmlentities(strip_tags(trim($_POST['bulan_tahun'])));
        $data_aktual = htmlentities(strip_tags(trim($_POST['data_aktual'])));

    }

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

    if ((!$pesan_error) && ($_POST["submit"] == "Update Data")) {

        $kode_retur = mysqli_real_escape_string($koneksi, $kode_retur);
        $kode_toko = mysqli_real_escape_string($koneksi, $kode_toko);
        $nama_toko = mysqli_real_escape_string($koneksi, $nama_toko);
        $kode_produk = mysqli_real_escape_string($koneksi, $kode_produk);
        $bulan_tahun = mysqli_real_escape_string($koneksi, $bulan_tahun);
        $data_aktual = mysqli_real_escape_string($koneksi, $data_aktual);

        $queryupdate = "UPDATE tb_retur1 SET ";
        $queryupdate .= "kode_toko = '$kode_toko', ";
        $queryupdate .= "nama_toko = '$nama_toko', ";
        $queryupdate .= "kode_produk = '$kode_produk', ";
        $queryupdate .= "bln_thn = '$bulan_tahun', jumlah_retur = '$data_aktual' ";
        $queryupdate .= "WHERE kode_retur = '$kode_retur'";

        $resultquery = mysqli_query($koneksi, $queryupdate);

        if ($resultquery) {
            $pesan_sukses = "Data retur berhasil diupdate!";
            $pesan_sukses = urlencode($pesan_sukses);
            header("Location: data_retur.php?pesan_sukses={$pesan_sukses}");
        } else {
            die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
        }
        mysqli_free_result($resultquery);
    }
    mysqli_close($koneksi);
} else {
    header("Location: data_retur.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data retur</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once 'sidebar.php'; ?>

    <div class="content-container">
        <div class="container-flukode_retur">
            <div class="jumbotron">
                <h2 style="margin-bottom: 25px;">Edit Data retur</h2>
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
                <form action="edit_retur.php" method="post" name="form1">
                    <div class="form-group">
                        <label for="kode_retur">Kode retur</label>
                        <input class="form-control" type="text" name="kode_retur" value="<?php echo $kode_retur; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kode_toko">Kode Toko</label>
                        <input class="form-control" type="text" name="kode_toko" value="<?php echo $kode_toko; ?>" readonly>
                    </div>
					<div class="form-group">
                        <label for="nama_toko">Nama Toko</label>
                        <input class="form-control" type="text" name="nama_toko" value="<?php echo $nama_toko; ?>" readonly>
                    </div>
					<div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input class="form-control" type="text" name="kode_produk" value="<?php echo $kode_produk; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bulan_tahun">Bulan - Tahun</label>
                        <input class="form-control" type="date" name="bulan_tahun" value="<?php echo $bulan_tahun; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="data_aktual">Data Aktual</label>
                        <input class="form-control" type="text" name="data_aktual" value="<?php echo $data_aktual; ?>" required>
                    </div>
                    <div style="display: flex;">
                        <div style="margin-top:20px;">
                            <input class="btn btn-primary" type="submit" name="submit" value="Update Data">
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
