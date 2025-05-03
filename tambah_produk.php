<?php
include_once("koneksi.php");

$kode_produk = "";
$nama_produk = "";
$pesan_error = array();

// Check If form submitted, insert form data into users table.
if(isset($_POST["submit"])) {
    $kode_produk = htmlentities(strip_tags(trim($_POST['kode_produk'])));
    $nama_produk = htmlentities(strip_tags(trim($_POST['nama_produk'])));

    $pesan_error = array();

    if (empty($kode_produk)) {
        $pesan_error[]= "Kode produk belum diisi!";
    }

    if (empty($nama_produk)) {
        $pesan_error[]= "Nama produk belum diisi!"; 
    }

    if (!$pesan_error) {
        $kode_produk = mysqli_real_escape_string($koneksi, $kode_produk);
        $nama_produk = mysqli_real_escape_string($koneksi, $nama_produk);

        $querytambah = "INSERT INTO tb_produk(kode_produk, nama_produk) ";
        $querytambah .= "VALUES('$kode_produk', '$nama_produk')";

        $resultquery = mysqli_query($koneksi, $querytambah);

        if ($resultquery) {
            $pesan_sukses = "Data produk berhasil ditambahkan!";
            $pesan_sukses = urlencode($pesan_sukses);
            header("Location: data_produk.php?pesan_sukses={$pesan_sukses}");
        } else {
            die("Query gagal dijalankan: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
        }
        
        mysqli_free_result($resultquery);
        mysqli_close($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Penjualan - SB Group</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- partial:index.partial.html -->
    <?php
    include_once 'sidebar.php';
    ?>

    <div class="content-container">
        <div class="container-fluid">
            <!-- Main component for a primary marketing message or call to action -->
            <div class="jumbotron">
                <h2 style="margin-bottom: 25px;">Tambah Data Produk</h2>
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
                <form action="tambah_produk.php" method="post" name="form1">
                    <div class="form-group">
                        <label for="kode_produk">Kode produk</label>
                        <input class="form-control" type="text" name="kode_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama produk</label>
                        <input class="form-control" type="text" name="nama_produk" required>
                    </div>
                    <div style="display: flex;">
                        <div style="margin-top:20px;">
                            <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                        </div>
                        <div style="margin: 20px 0px 0px 20px;">
                            <a class="btn btn-danger" href="data_produk.php">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- partial -->
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</body>
</html>
