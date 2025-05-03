<?php
include_once("koneksi.php");
session_start();

$username = "";
$password = "";
$pesan_login = "";

if (isset($_POST["submit"])) {
    // Sanitasi input
    $username = mysqli_real_escape_string($koneksi, trim($_POST["username"]));
    $password = mysqli_real_escape_string($koneksi, trim($_POST["password"]));

    // Query cek username dan password
    $querylogin = "SELECT * FROM tb_admin WHERE username='$username' AND password='$password'";
    $resultquery = mysqli_query($koneksi, $querylogin);

    if (mysqli_num_rows($resultquery) === 1) {
        $row = mysqli_fetch_assoc($resultquery);
        $_SESSION["username"] = $row["username"];

        // Redirect ke index.php setelah login sukses
        header("Location: index.php");
        exit();
    } else {
        $pesan_login = "Username atau password salah!";
    }

    mysqli_free_result($resultquery);
    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpg" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<?php if ($pesan_login !== ""): ?>
								<div class='alert alert-danger alert-dismissible'>
									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
									<strong>Gagal!</strong> <?= $pesan_login ?>
								</div>
							<?php endif; ?>

							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" novalidate action="">
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" name="username" required autofocus>
									<div class="invalid-feedback">Username belum diisi!</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password" required>
									<div class="invalid-feedback">Password belum diisi!</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" name="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer text-center mt-3 text-muted">© <?= date("Y") ?> Klinik Anda</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="js/my-login.js"></script>
</body>
</html>
