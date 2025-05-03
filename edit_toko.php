<?php

session_start();

if (!isset($_SESSION["username"])) {
  header("Location: login.php");
}

include_once("koneksi.php");

if (isset($_POST["submit"])) {
	if ($_POST["submit"] == "Edit") {

		$id = htmlentities(strip_tags(trim($_POST["kode_toko"])));
		$id = mysqli_real_escape_string($koneksi, $id);

		$querytampilid = "SELECT * FROM tb_daftar_toko WHERE id ='$id'";
		$resultquery = mysqli_query($koneksi, $querytampilid);

		if (!$resultquery) {
			die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
		}

		$data = mysqli_fetch_assoc($resultquery);

		$id = $data["id"];

		$kode_toko = $data["kode_toko"];
		$nama_toko = $data["nama_toko"];

		mysqli_free_result($resultquery);

	} else if ($_POST["submit"] == "Update Data") {

		$id = htmlentities(strip_tags(trim($_POST["id"])));
		$kode_toko = htmlentities(strip_tags(trim($_POST["kode_toko"])));
		$nama_toko = htmlentities(strip_tags(trim($_POST["nama_toko"])));

	}

	$pesan_error = array();

	if (empty($kode_toko)) {
		$pesan_error[] = "Kode toko belum diisi!";
	}

	if (empty($nama_toko)) {
		$pesan_error[] = "Nama toko belum diisi!";
	}


	if ((!$pesan_error) && ($_POST["submit"] == "Update Data")) {

		$id = mysqli_real_escape_string($koneksi, $id);
		$kode_toko = mysqli_real_escape_string($koneksi, $kode_toko);
		$nama_toko = mysqli_real_escape_string($koneksi, $nama_toko);

		$queryupdate = "UPDATE tb_daftar_toko SET ";
		$queryupdate .= "kode_toko = '$kode_toko', nama_toko = '$nama_toko' ";
		$queryupdate .= "WHERE id = '$id'";

		$resultquery = mysqli_query($koneksi, $queryupdate);

		if ($resultquery) {
			$pesan_sukses = "Data toko berhasil diupdate!";
			$pesan_sukses = urlencode($pesan_sukses);
			header("Location: data_toko.php?pesan_sukses={$pesan_sukses}");
		} else {
			die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
		}
		mysqli_free_result($resultquery);
	}
	mysqli_close($koneksi);
} else {
	header("Location: data_toko.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Data Penjualan - SB Group</title>
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
				<h2 style="margin-bottom: 25px;">Edit Data Toko</h2>
				<?php
				if ($pesan_error !== "") {
					foreach ($pesan_error as $per) {
						echo "<div class='alert alert-danger alert-dismissible'>
						<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Gagal!</strong> " . $per .
							"</div>";
					}
				}
				?>
				<form action="edit_toko.php" method="post" name="update_data">
					<div>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
					</div>
					<div class="form-group">
						<label for="kode_toko">Kode Toko</label>
						<input class="form-control" type="text" name="kode_toko" value="<?php echo $kode_toko; ?>" required>
					</div>
					<div class="form-group">
						<label for="nama_toko">Nama Toko</label>
						<input class="form-control" type="text" name="nama_toko" value="<?php echo $nama_toko; ?>" required>
					</div>
					<div style="display: flex;">
						<div style="margin-top:20px;">
							<input class="btn btn-primary" type="submit" name="submit" value="Update Data">
						</div>
						<div style="margin: 20px 0px 0px 20px;">
							<a class="btn btn-danger" href="data_toko.php">Batal</a>
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
