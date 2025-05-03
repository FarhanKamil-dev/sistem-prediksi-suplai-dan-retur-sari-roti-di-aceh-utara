<?php

session_start();

if (!isset($_SESSION["username"])) {
	header("Location: login.php");
}

include_once("koneksi.php");

if (isset($_POST["nama_produk"])) {
    $nama_produk = $_POST["nama_produk"];
} else {
    // Tindakan jika $_POST["nama_produk"] tidak ada, misalnya beri nilai default atau tampilkan pesan kesalahan.
    $nama_produk = ""; // Atau tindakan lain sesuai kebutuhan Anda.
}


$querytampil = "SELECT p.kode_produk, d.bln_thn,  SUM(d.jumlah_dropping) AS jumlah_dropping 
FROM tb_dropping d 
JOIN tb_produk p ON d.kode_produk = p.kode_produk 
WHERE d.nama_toko = 'modi'  AND p.kode_produk = '$nama_produk' 
GROUP BY d.nama_toko, d.bln_thn, p.kode_produk 
ORDER BY d.bln_thn";

$queryalpha = "select * from tb_alpha where id_alpha = 'A1'";
$querysum = "SELECT SUM(jumlah_dropping)
FROM tb_dropping
WHERE nama_toko = 'modi' 
AND kode_produk = (SELECT kode_produk FROM tb_produk WHERE kode_produk = '$nama_produk')";
$pesan_error = "";

if (isset($_GET['pesan_sukses'])) {
	$pesan_sukses = $_GET['pesan_sukses'];
}

if (isset($_POST["submit"])) {
	if ($_POST["submit"]="Ganti Alpha") {
		$id_alpha = htmlentities(strip_tags(trim($_POST['id_alpha'])));
		$n_alpha = htmlentities(strip_tags(trim($_POST['nilai_alpha'])));
		$nama_produk = htmlentities(strip_tags(trim($_POST['nama_produk'])));


		$pesan_error = "";

		if (empty($n_alpha)) {
			$pesan_error = "Nilai alpha belum di isi!";
		}

		if (($pesan_error === "") AND ($_POST["submit"]="Ganti Alpha")) {
			$id_alpha = mysqli_real_escape_string($koneksi,$id_alpha);
			$n_alpha = mysqli_real_escape_string($koneksi,$n_alpha);

			$queryupdatealpha = "update tb_alpha set nilai_alpha = '$n_alpha' where id_alpha = '$id_alpha'";

			$resultquery = mysqli_query($koneksi,$queryupdatealpha);

			if ($resultquery) {
				$pesan_sukses = "Alpha berhasil diupdate!<br>";
				$pesan_sukses = urlencode($pesan_sukses);
				header("Location: peramalan_modi_dropping.php?pesan_sukses={$pesan_sukses}");
			}
			else {
				die("Query gagal dijalankan: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
			}

			mysqli_free_result($resultquery);

		}
	}
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="UTF-8">
	<title>Prediksi - Fatih Market</title>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<script src="js/chart.min.js"></script>
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
				<h2 style="margin-bottom: 25px;">TOKO MODI</h2>
				<h3 style="margin-bottom: 25px;"><?php echo $nama_produk;?></h3>
				<h4 style="margin-bottom: 25px;">A. Data Prediksi Dropping Periode Berikutnya </h4>
				<div style="margin-bottom: 10px;">
					<?php
					// if ($pesan_error!=="") {
					// 	echo "<div class='alert alert-danger alert-dismissible'>
					// 	<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					// 	<strong >Gagal!</strong> ".$pesan_error.
					// 	"</div>";
					// }

					if (isset($pesan_sukses)) {
						echo "<div class='alert alert-success alert-dismissible'>
						<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Berhasil!</strong> ".$pesan_sukses.
						"</div>";
					}

					$resultquery = mysqli_query($koneksi,$queryalpha);

					If(!$resultquery){
						die("Query Error : ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
					}

					$data_alpha = mysqli_fetch_assoc($resultquery);
					?>
					<div class="row">
						<div class="col-sm-4">
							<div class="alert alert-info">
								<h6>Nilai alpha saat ini adalah: <b><?php echo $data_alpha['nilai_alpha']; ?></b></h6>
							</div>
						</div>

						<div class="col-sm-5">
							<form action="peramalan_modi_dropping.php" method="post" name="ubah_alpha" class="form-inline" onsubmit="return submitForm();">
								<div class="form-group">
									<input type="text" class="form-control" name="nilai_alpha" id="nilai_alpha" placeholder="Ganti Nilai Alpha"><br>
								</div>

								<div class="form-group mx-sm-0">
									<select class="form-control" name="nama_produk" required>
										<?php
										$query_toko = "SELECT kode_produk, nama_produk FROM tb_produk";
										$result_toko = mysqli_query($koneksi, $query_toko);

										while ($row = mysqli_fetch_assoc($result_toko)) {
											echo "<option value='" . $row['kode_produk'] . "'>" . $row['kode_produk'] . " - " . $row['nama_produk'] . "</option>";
										}
										?>
									</select>
								</div>

								<input type="hidden" name="id_alpha" value="<?php echo $data_alpha['id_alpha']; ?>">

								<div class="form-group">
									<button type="submit" class="btn btn-primary" name="submit" value="Ganti Alpha">Ganti Alpha</button>
								</div>
							</form>
						</div>
					</div>

					<?php
					$id_alpha = $data_alpha["id_alpha"];
					$n_alpha = $data_alpha["nilai_alpha"];
					?>


				</div>
				<div class="row">
					<div class="col-sm-9">
						<table class="table table-hover table-bordered">
							<tr>
                                <!-- <th>Nama Toko</th> -->
								<th>Tanggal</th>
								<th>Data Aktual</th>
								<!-- <th>Level</th>
								<th>Trend</th>
								<th>Seasonal</th> -->
								<th>Data Perkiraan</th>
								<th>Error</th>
								<th>Abs Error</th>
								<th>Abs Error^2</th>
								<th>Abs Error %</th>
							</tr>
							<?php
		//untuk menentukan nilai peramalan pertama
							$resultquery = mysqli_query($koneksi,$querysum);
							$hasilsum = mysqli_fetch_row($resultquery);

							$resultquery = mysqli_query($koneksi,$querytampil);
							$d_perkiraan = "";
							$count = mysqli_num_rows($resultquery);
							$loop = 0;
							$sum_abs_err = 0;
							$sum_abs_err2 = 0;
							$sum_abs_err_percent = 0;

							while ($row=mysqli_fetch_row($resultquery))
							{
			//inisiasi data perkiraan pertama
								if ($d_perkiraan === "") {
									$d_perkiraan = $hasilsum[0]/$count;
								}
								else {
									$d_perkiraan = $h_perkiraan;
								}

								$array_perkiraan[] = $d_perkiraan;

			//rumus error
								$error = $row[2]-$d_perkiraan;


			//rumus absolute error
								$abs_err = abs($error);
								$sum_abs_err = $sum_abs_err+$abs_err;

			//rumus absolute error pangkat 2
								$abs_err2 = pow($error, 2);
								$sum_abs_err2 = $sum_abs_err2+$abs_err2;

			//rumus absolute error %
								$abs_err_percent = abs((($row[2]-$d_perkiraan)/$row[2])*100);
								$sum_abs_err_percent = $sum_abs_err_percent+$abs_err_percent;

								echo "<tr>";
								echo "<td>$row[1]</td>
								<td>$row[2]</td>
								<td>".number_format($d_perkiraan,3)."</td>
								<td>".number_format($error,3)."</td>
								<td>".number_format($abs_err,3)."</td>
								<td>".number_format($abs_err2,3)."</td>
								<td>".number_format($abs_err_percent,3)."%</td>";
								echo "</tr>";

			//rumus single exponential smoothing
								$h_perkiraan = $d_perkiraan+$n_alpha*($row[2]-$d_perkiraan);

			//jika data sudah ditampilkan semua, lakukan peramalan untuk Periode berikutnya
								$loop = $loop+1;
								if ($loop == $count) {
									echo "</table></div>";
									$d_aktual_next = $row[2];
									$d_perkiraan_next = $d_perkiraan;
									$d_ft = $d_perkiraan_next+$n_alpha*($d_aktual_next-$d_perkiraan_next);

				//rumus MAPE
									$rata_abs_error_percent = $sum_abs_err_percent/$count;

				//rumus rata2 abs_err MAD
									$rataabs_err = $sum_abs_err/$count;


									?>
									<div class="col-sm-3">
										<div class="card">
											<div class="card-header">
												<h5 style="margin-left: 20px;">MAPE : <?php echo number_format($rata_abs_error_percent,3);?></h5>
												<h5 style="margin-left: 20px;">MAD : <?php echo number_format($rataabs_err,3);?></h5>
											</div>
										</div>
									</div>
								</div>
								<h4 class="alert alert-info">Perkiraan untuk Periode berikutnya adalah <?php echo number_format($d_ft,3);?></h4>
								<?php
							}

						}
						?>

						<h2 style="margin-bottom: 25px; margin-top: 50px;">B. Grafik Peramalan Periode Berikutnya</h2>
						<!-- Grafik -->
						<div class="t">
							<canvas id="speedChart"></canvas>
						</div>
						<script>
							var speedCanvas = document.getElementById("speedChart");

							Chart.defaults.global.defaultFontFamily = "Times New Roman";
							Chart.defaults.global.defaultFontSize = 15;

							var dataFirst = {
								label: "Aktual",
								data: [<?php
									$querydaktual = "SELECT p.kode_produk, d.bln_thn,  SUM(d.jumlah_dropping) AS jumlah_dropping 
									FROM tb_dropping d 
									JOIN tb_produk p ON d.kode_produk = p.kode_produk 
									WHERE d.nama_toko = 'modi'  AND p.kode_produk = '$nama_produk' 
									GROUP BY d.nama_toko, d.bln_thn, p.kode_produk 
									ORDER BY d.bln_thn";
									$resultquery = mysqli_query($koneksi,$querydaktual);

									If(!$resultquery){
										die("Query Error : ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
									}

									while ($data_aktual = mysqli_fetch_assoc($resultquery)) {
										echo "$data_aktual[jumlah_dropping], ";
									}
									?>],

									lineTension: 0.3,
									fill: false,
									borderColor: '#FFD662',
									backgroundColor: '#FFD662',
									pointBorderColor: '#FFD662',
									pointBackgroundColor: '#FFD662',
									pointRadius: 5,
									pointHoverRadius: 15,
									pointHitRadius: 30,
									pointBorderWidth: 2,
									pointStyle: 'rect'
								};

								var dataSecond = {
									label: "Perkiraan",
									data: [<?php
										foreach ($array_perkiraan as $arper) {
											echo "".$arper.", ";
										}
										echo "".$d_ft."";
										?>],

										lineTension: 0.3,
										fill: false,
										borderColor: '#007bff',
										backgroundColor: '#007bff',
										pointBorderColor: '#007bff',
										pointBackgroundColor: '#007bff',
										pointRadius: 5,
										pointHoverRadius: 15,
										pointHitRadius: 30,
										pointBorderWidth: 2
									};

									var speedData = {
										labels: [<?php
											$queryPeriode = "SELECT p.kode_produk, d.bln_thn,  SUM(d.jumlah_dropping) AS jumlah_dropping 
											FROM tb_dropping d 
											JOIN tb_produk p ON d.kode_produk = p.kode_produk 
											WHERE d.nama_toko = 'modi'  AND p.kode_produk = '$nama_produk' 
											GROUP BY d.nama_toko, d.bln_thn, p.kode_produk 
											ORDER BY d.bln_thn";
											$resultquery = mysqli_query($koneksi,$queryPeriode);

											If(!$resultquery){
												die("Query Error : ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
											}

											while ($data_Periode = mysqli_fetch_assoc($resultquery)) {
												echo "\"$data_Periode[bln_thn]\", ";
											}
											echo "\"Periode berikutnya\"";
											?>],
						//labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
						datasets: [dataFirst, dataSecond]
					};

					var chartOptions = {
						legend: {
							display: true,
							position: 'top',
							labels: {
								boxWidth: 80,
								fontColor: 'black'
							}
						}
					};

					var lineChart = new Chart(speedCanvas, {
						type: 'line',
						data: speedData,
						options: chartOptions
					});

				</script>
				<?php
				mysqli_free_result($resultquery);
				mysqli_close($koneksi);
				?>

			</div>

		</div>
	</div>
	<!-- partial -->
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</body>
</html>