<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Filter & filter pada PHP ke Semua Kolom</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.container {
			margin-top: 30px;
		}

		.container h2 {
			margin-bottom: 30px;
		}

		.form-group {
			margin-bottom: 10px;
		}
	</style>
</head>
<body> 
	<div class="container">
		<h2 align="center">Filter &amp; filter pada PHP ke Semua Kolom</h2>
		<?php 
			$produk = "";
			if (isset($_POST['filter'])) {
				$produk = $_POST['produk'];
			}
		?>
		<form method="POST" action="">
			<div class="row mb-3">
				<div class="col-sm-12"><h4>Cari</h4></div>
				<div class="col-sm-3">
					<div class="form-group">
					<select name="produk" id="produk" class="form-control">
							<option value="">Filter produk</option>
							<option value="BAUMKUCHEN COKELAT" <?php if ($produk=="BAUMKUCHEN COKELAT") { echo "selected"; } ?>>BAUMKUCHEN COKELAT</option>
							<option value="BAUMKUCHEN ORIGINAL" <?php if ($produk=="BAUMKUCHEN ORIGINAL") { echo "selected"; } ?>>BAUMKUCHEN ORIGINAL</option>
							<option value="BOLU KUKUS VANILA" <?php if ($produk=="BOLU KUKUS VANILA") { echo "selected"; } ?>>BOLU KUKUS VANILA</option>
							<option value="Bolu Kukus Putih Cokelat" <?php if ($produk=="Bolu Kukus Putih Cokelat") { echo "selected"; } ?>>Bolu Kukus Putih Cokelat</option>
							<option value="BOTI BANTAL ORIGINAL" <?php if ($produk=="BOTI BANTAL ORIGINAL") { echo "selected"; } ?>>BOTI BANTAL ORIGINAL</option>
							<option value="BOTI BANTAL PANDAN" <?php if ($produk=="BOTI BANTAL PANDAN") { echo "selected"; } ?>>BOTI BANTAL PANDAN</option>
							<option value="BOTI ISI COKELAT" <?php if ($produk=="BOTI ISI COKELAT") { echo "selected"; } ?>>BOTI ISI COKELAT</option>
							<option value="BOTI TAWAR KLASIK" <?php if ($produk=="BOTI TAWAR KLASIK") { echo "selected"; } ?>>BOTI TAWAR KLASIK</option>
							<option value="Cheese Cake Coffee Mocca" <?php if ($produk=="Cheese Cake Coffee Mocca") { echo "selected"; } ?>>Cheese Cake Coffee Mocca</option>
							<option value="CHEESE CAKE ORIGINAL" <?php if ($produk=="CHEESE CAKE ORIGINAL") { echo "selected"; } ?>>CHEESE CAKE ORIGINAL</option>
							<option value="DORAYAKI CHOCO PEANUT" <?php if ($produk=="DORAYAKI CHOCO PEANUT") { echo "selected"; } ?>>DORAYAKI CHOCO PEANUT</option>
							<option value="DORAYAKI CHEESE HOKAIDO" <?php if ($produk=="DORAYAKI CHEESE HOKAIDO") { echo "selected"; } ?>>DORAYAKI CHEESE HOKAIDO</option>
							<option value="DORAYAKI HONEY FLAVOUR" <?php if ($produk=="DORAYAKI HONEY FLAVOUR") { echo "selected"; } ?>>DORAYAKI HONEY FLAVOUR</option>
							<option value="DORAYAKI ISI COKLAT" <?php if ($produk=="DORAYAKI ISI COKLAT") { echo "selected"; } ?>>DORAYAKI ISI COKLAT</option>
							<option value="DORAYAKI ISI COKLAT" <?php if ($produk=="DORAYAKI ISI COKLAT") { echo "selected"; } ?>>DORAYAKI ISI COKLAT</option>
							<option value="ISI KUE PUTU" <?php if ($produk=="ISI KUE PUTU") { echo "selected"; } ?>>ISI KUE PUTU</option>
							<option value="ISI KRIM MESSES FAMILY PACK 3 PCS" <?php if ($produk=="ISI KRIM MESSES FAMILY PACK 3 PCS") { echo "selected"; } ?>>ISI KRIM MESSES FAMILY PACK 3 PCS</option>
							<option value="KASUR KEJU II" <?php if ($produk=="KASUR KEJU II") { echo "selected"; } ?>>KASUR KEJU II</option>
							<option value="KASUR SUSU II" <?php if ($produk=="KASUR SUSU II") { echo "selected"; } ?>>KASUR SUSU II</option>
							<option value="KLASIK PAN PANDAN" <?php if ($produk=="KLASIK PAN PANDAN") { echo "selected"; } ?>>KLASIK PAN PANDAN</option>
							<option value="KLASIK PAN SUSU" <?php if ($produk=="KLASIK PAN SUSU") { echo "selected"; } ?>>KLASIK PAN SUSU</option>
							<option value="Lapis Surabaya Premium Keju" <?php if ($produk=="Lapis Surabaya Premium Keju") { echo "selected"; } ?>>Lapis Surabaya Premium Keju</option>
							<option value="Lapis Surabaya Premium Original" <?php if ($produk=="Lapis Surabaya Premium Original") { echo "selected"; } ?>>Lapis Surabaya Premium Original</option>
							<option value="ROTI CREAM COKLAT II" <?php if ($produk=="ROTI CREAM COKLAT II") { echo "selected"; } ?>>ROTI CREAM COKLAT II</option>
							<option value="ROTI CREAM COKLAT VANILLA II" <?php if ($produk=="ROTI CREAM COKLAT VANILLA II") { echo "selected"; } ?>>ROTI CREAM COKLAT VANILLA II</option>
							<option value="ROTI CREAM KEJU II" <?php if ($produk=="ROTI CREAM KEJU II") { echo "selected"; } ?>>ROTI CREAM KEJU II</option>
							<option value="ROTI DUO KLASIK KRIM MESES" <?php if ($produk=="ROTI DUO KLASIK KRIM MESES") { echo "selected"; } ?>>ROTI DUO KLASIK KRIM MESES</option>
							<option value="ROTI DUO SOBEK COKELAT BLUEBERRY" <?php if ($produk=="ROTI DUO SOBEK COKELAT BLUEBERRY") { echo "selected"; } ?>>ROTI DUO SOBEK COKELAT BLUEBERRY</option>
							<option value="ROTI DUO SOBEK COKELAT STRAWBERRY" <?php if ($produk=="ROTI DUO SOBEK COKELAT STRAWBERRY") { echo "selected"; } ?>>ROTI DUO SOBEK COKELAT STRAWBERRY</option>
							<option value="ROTI ISI COKELAT II" <?php if ($produk=="ROTI ISI COKELAT II") { echo "selected"; } ?>>ROTI ISI COKELAT II</option>
							<option value="ROTI ISI COKELAT KEJU II" <?php if ($produk=="ROTI ISI COKELAT KEJU II") { echo "selected"; } ?>>ROTI ISI COKELAT KEJU II</option>
							<option value="ROTI JUMBO TAWAR KUPAS II" <?php if ($produk=="ROTI JUMBO TAWAR KUPAS II") { echo "selected"; } ?>>ROTI JUMBO TAWAR KUPAS II</option>
							<option value="ROTI JUMBO TAWAR SPECIAL II" <?php if ($produk=="ROTI JUMBO TAWAR SPECIAL II") { echo "selected"; } ?>>ROTI JUMBO TAWAR SPECIAL II</option>
							<option value="ROTI KLASIK ISI KRIM MESSES" <?php if ($produk=="ROTI KLASIK ISI KRIM MESSES") { echo "selected"; } ?>>ROTI KLASIK ISI KRIM MESSES</option>
							<option value="ROTI KRIM COKELAT MESES" <?php if ($produk=="ROTI KRIM COKELAT MESES") { echo "selected"; } ?>>ROTI KRIM COKELAT MESES</option>
							<option value="ROTI SOBEK COKLAT BLUEBERRY II 5S" <?php if ($produk=="ROTI SOBEK COKLAT BLUEBERRY II 5S") { echo "selected"; } ?>>ROTI SOBEK COKLAT BLUEBERRY II 5S</option>
							<option value="ROTI SOBEK COKLAT COKLAT II" <?php if ($produk=="ROTI SOBEK COKLAT COKLAT II") { echo "selected"; } ?>>ROTI SOBEK COKLAT COKLAT II</option>
							<option value="ROTI SOBEK COKLAT II 5S" <?php if ($produk=="ROTI SOBEK COKLAT II 5S") { echo "selected"; } ?>>ROTI SOBEK COKLAT II 5S</option>
							<option value="ROTI SOBEK COKLAT KEJU II" <?php if ($produk=="ROTI SOBEK COKLAT KEJU II") { echo "selected"; } ?>>ROTI SOBEK COKLAT KEJU II</option>
							<option value="ROTI SOBEK COKLAT KEJU II 5S" <?php if ($produk=="ROTI SOBEK COKLAT KEJU II 5S") { echo "selected"; } ?>>ROTI SOBEK COKLAT KEJU II 5S</option>
							<option value="ROTI SOBEK COKLAT SARIKAYA II" <?php if ($produk=="ROTI SOBEK COKLAT SARIKAYA II") { echo "selected"; } ?>>ROTI SOBEK COKLAT SARIKAYA II</option>
							<option value="ROTI SOBEK COKLAT SARIKAYA II 5S" <?php if ($produk=="ROTI SOBEK COKLAT SARIKAYA II 5S") { echo "selected"; } ?>>ROTI SOBEK COKLAT SARIKAYA II 5S</option>
							<option value="ROTI SOBEK COKLAT STRAWBERRY II" <?php if ($produk=="ROTI SOBEK COKLAT STRAWBERRY II") { echo "selected"; } ?>>ROTI SOBEK COKLAT STRAWBERRY II</option>
							<option value="ROTI SOBEK COKLAT STRAWBERRY II 5S" <?php if ($produk=="ROTI SOBEK COKLAT STRAWBERRY II 5S") { echo "selected"; } ?>>ROTI SOBEK COKLAT STRAWBERRY II 5S</option>
							<option value="ROTI SISIR MENTEGA II" <?php if ($produk=="ROTI SISIR MENTEGA II") { echo "selected"; } ?>>ROTI SISIR MENTEGA II</option>
							<option value="ROTI TAWAR CHOCO CHIP II" <?php if ($produk=="ROTI TAWAR CHOCO CHIP II") { echo "selected"; } ?>>ROTI TAWAR CHOCO CHIP II</option>
							<option value="ROTI TAWAR DOUBLE SOFT II" <?php if ($produk=="ROTI TAWAR DOUBLE SOFT II") { echo "selected"; } ?>>ROTI TAWAR DOUBLE SOFT II</option>
							<option value="ROTI TAWAR DOUBLE SOFT PREMIUM" <?php if ($produk=="ROTI TAWAR DOUBLE SOFT PREMIUM") { echo "selected"; } ?>>ROTI TAWAR DOUBLE SOFT PREMIUM</option>
							<option value="ROTI TAWAR GANDUM II" <?php if ($produk=="ROTI TAWAR GANDUM II") { echo "selected"; } ?>>ROTI TAWAR GANDUM II</option>
							<option value="ROTI TAWAR JUMBO MILKY SOFT" <?php if ($produk=="ROTI TAWAR JUMBO MILKY SOFT") { echo "selected"; } ?>>ROTI TAWAR JUMBO MILKY SOFT</option>
							<option value="ROTI TAWAR KUPAS II" <?php if ($produk=="ROTI TAWAR KUPAS II") { echo "selected"; } ?>>ROTI TAWAR KUPAS II</option>
							<option value="ROTI TAWAR MILKY SOFT" <?php if ($produk=="ROTI TAWAR MILKY SOFT") { echo "selected"; } ?>>ROTI TAWAR MILKY SOFT</option>
							<option value="ROTI TAWAR PANDAN MANIS II" <?php if ($produk=="ROTI TAWAR PANDAN MANIS II") { echo "selected"; } ?>>ROTI TAWAR PANDAN MANIS II</option>
							<option value="Roti Duo Sobek Cokelat Sarikaya" <?php if ($produk=="Roti Duo Sobek Cokelat Sarikaya") { echo "selected"; } ?>>Roti Duo Sobek Cokelat Sarikaya</option>
							<option value="SANDWICH BLUEBERRY II" <?php if ($produk=="SANDWICH BLUEBERRY II") { echo "selected"; } ?>>SANDWICH BLUEBERRY II</option>
							<option value="SANDWICH COKLAT II" <?php if ($produk=="SANDWICH COKLAT II") { echo "selected"; } ?>>SANDWICH COKLAT II</option>
							<option value="SANDWICH KRIM KEJU II" <?php if ($produk=="SANDWICH KRIM KEJU II") { echo "selected"; } ?>>SANDWICH KRIM KEJU II</option>
							<option value="SANDWICH KRIM PEANUT II" <?php if ($produk=="SANDWICH KRIM PEANUT II") { echo "selected"; } ?>>SANDWICH KRIM PEANUT II</option>
							<option value="SANDWICH MARGARIN GULA II" <?php if ($produk=="SANDWICH MARGARIN GULA II") { echo "selected"; } ?>>SANDWICH MARGARIN GULA II</option>
							<option value="SANDWICH PANDAN SARIKAYA MEDAN II" <?php if ($produk=="SANDWICH PANDAN SARIKAYA MEDAN II") { echo "selected"; } ?>>SANDWICH PANDAN SARIKAYA MEDAN II</option>
							<option value="STEAM CHEESE CAKE COKELAT" <?php if ($produk=="STEAM CHEESE CAKE COKELAT") { echo "selected"; } ?>>STEAM CHEESE CAKE COKELAT</option>
							<option value="STEAM CHEESE CAKE ORIGINAL" <?php if ($produk=="STEAM CHEESE CAKE ORIGINAL") { echo "selected"; } ?>>STEAM CHEESE CAKE ORIGINAL</option>
							<option value="SobeK DUO COKELAT" <?php if ($produk=="SobeK DUO COKELAT") { echo "selected"; } ?>>SobeK DUO COKELAT</option>
							<option value="SobeK DUO COKELAT KEJU" <?php if ($produk=="SobeK DUO COKELAT KEJU") { echo "selected"; } ?>>SobeK DUO COKELAT KEJU</option>
						</select>
					</div>
				
				</div>
				<div class="col-sm-4">
					<button id="filter" name="filter" class="btn btn-warning">Cari</button>
				</div>
			</div>
		</form>
	 
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<td>Nama Produk</td>
					<td>Bulan-Tahun</td>
					<td>Jumlah Retur</td>
				</tr>
			</thead>
			<tbody>
				<?php
				include 'koneksi.php';
				$filter_produk = '%'. $produk .'%';
				$no = 1;
				$query = "SELECT p.nama_produk, r.bln_thn, SUM(r.jumlah_retur) AS jumlah_retur
				FROM tb_retur1 r
				JOIN tb_produk p ON r.kode_produk = p.kode_produk
				WHERE r.nama_toko = 'kardana' AND p.nama_produk LIKE ?
				GROUP BY p.nama_produk, r.bln_thn";
				
				$dewan1 = $koneksi->prepare($query);
				$dewan1->bind_param('s', $filter_produk);
				$dewan1->execute();
				$res1 = $dewan1->get_result();
	 
				if ($res1->num_rows > 0) {
					while ($row = $res1->fetch_assoc()) {
						$nama_produk = $row['nama_produk'];
						$bln_thn = $row['bln_thn'];
						$jumlah_retur = $row['jumlah_retur'];
				?>
					<tr>
						<td><?php echo $nama_produk; ?></td>
						<td><?php echo $bln_thn; ?></td>
						<td><?php echo $jumlah_retur; ?></td>

					</tr>
				<?php } } else { ?> 
					<tr>
						<td colspan='6'>Tidak ada data ditemukan</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
