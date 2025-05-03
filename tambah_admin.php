<?php

include_once("koneksi.php");

$username = "";
$password = "";
$level_user ="";
$pesan_error = array();

	// Check If form submitted, insert form data into users table.
if(isset($_POST["submit"])) {
	$username = htmlentities(strip_tags(trim($_POST['username'])));
	$password = htmlentities(strip_tags(trim($_POST['password'])));
	$level_user = htmlentities(strip_tags(trim($_POST['level_user'])));

	$pesan_error = array();

	if (empty($password)) {
		$pesan_error[]= "Username belum di isi!";
	}

	if (empty($password)) {
		$pesan_error[]= "Password belum di isi!";
	}
	if (empty($level_user)) {
		$pesan_error[]= "level_user belum di isi!";
	}


	if (!$pesan_error) {
		$username = mysqli_real_escape_string($koneksi,$username);
		$password = mysqli_real_escape_string($koneksi,$password);
		$level_user = mysqli_real_escape_string($koneksi,$level_user);

		$querytambah = "INSERT INTO tb_admin (username,password,level_user) ";
		$querytambah .= "VALUES('$username','$password','$level_user')";

		$resultquery = mysqli_query($koneksi,$querytambah);

		if ($resultquery) {
			$pesan_sukses = "Data admin \"<b>$username</b>\" berhasil ditambahkan!";
			$pesan_sukses = urlencode($pesan_sukses);
			header("Location: data_admin.php?pesan_sukses={$pesan_sukses}");
		}
		else {
			die("Query gagal dijalankan: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
		}
		mysqli_free_result($resultquery);
		mysqli_close($koneksi);
	}
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="UTF-8">
	<title>Tambah Pengguna</title>
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
				<h2 style="margin-bottom: 25px;">Tambah Data Pengguna</h2>
				<?php
				if ($pesan_error !=="") {
					foreach ($pesan_error as $per) {
						echo "<div class='alert alert-danger alert-dismissible'>
						<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Gagal!</strong> ".$per.
						"</div>";
					}
				}
				?>
				<form action="tambah_admin.php" method="post" name="form1">
					<div class="form-group">
						<label for="username">Username</label>
						<input class="form-control" type="text" name="username">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="text" name="password">
					</div>
					<div class="form-group">
						<label for="level_user">level_user</label>
						<input class="form-control" type="text" name="level_user">
					</div>
					<div style="display: flex;">
						<div style="margin-top:20px;">
							<input class="btn btn-primary" type="submit" name="submit" value="Simpan">
						</div>
						<div style="margin: 20px 0px 0px 20px;">
							<a class="btn btn-danger" href="data_admin.php">Batal</a>
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