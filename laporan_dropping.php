<?php
session_start();

if (!isset($_SESSION["username"])) {
	header("Location: login.php");
}

include_once("koneksi.php");

$querytampil = "SELECT tb_dropping.kode_dropping, tb_dropping.nama_toko, tb_produk.nama_produk, tb_dropping.bln_thn, tb_dropping.jumlah_dropping FROM tb_dropping
INNER JOIN tb_produk ON tb_dropping.kode_produk = tb_produk.kode_produk";

// Simpan parameter pencarian di session
$_SESSION['search_nama_toko'] = isset($_GET['search_nama_toko']) ? $_GET['search_nama_toko'] : '';
$_SESSION['search_nama_produk'] = isset($_GET['search_nama_produk']) ? $_GET['search_nama_produk'] : '';

// Mengambil nilai pencarian nama toko dari session
$search_nama_toko = isset($_SESSION['search_nama_toko']) ? $_SESSION['search_nama_toko'] : '';

// Mengambil nilai pencarian nama produk dari session
$search_nama_produk = isset($_SESSION['search_nama_produk']) ? $_SESSION['search_nama_produk'] : '';


// Mengambil nilai pencarian nama toko
if (isset($_GET['search_nama_toko']) && $_GET['search_nama_toko'] != '') {
	$search_nama_toko = $_GET['search_nama_toko'];
	$querytampil .= " WHERE tb_dropping.nama_toko LIKE '%$search_nama_toko%'";
}

// Mengambil nilai pencarian nama produk
if (isset($_GET['search_nama_produk']) && $_GET['search_nama_produk'] != '') {
	$search_nama_produk = $_GET['search_nama_produk'];
	$querytampil .= isset($_GET['search_nama_toko']) && $_GET['search_nama_toko'] != '' ? " AND" : " WHERE";
	$querytampil .= " tb_produk.nama_produk LIKE '%$search_nama_produk%'";
}
// Mengambil nilai pencarian tanggal awal dan tanggal akhir
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Tambahkan filter tanggal awal dan tanggal akhir jika telah diisi
if (!empty($start_date) && !empty($end_date)) {
    $querytampil .= " WHERE tb_dropping.bln_thn BETWEEN '$start_date' AND '$end_date'";
} elseif (!empty($start_date)) {
    $querytampil .= " WHERE tb_dropping.bln_thn >= '$start_date'";
} elseif (!empty($end_date)) {
    $querytampil .= " WHERE tb_dropping.bln_thn <= '$end_date'";
}


if (isset($_GET['pesan_sukses'])) {
	$pesan_sukses = $_GET['pesan_sukses'];
}

// Variabel untuk pagination
$limit = 15;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$querytampil .= " LIMIT $start, $limit";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Prediksi - Sari Roti</title>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php
	include_once 'sidebar.php';
	?>

	<div class="content-container">
		<div class="container-fluid">
			<div class="jumbotron">
				<h2 style="margin-bottom: 25px;">Laporan Data Dropping Roti</h2>
				<?php
				if (isset($pesan_sukses)) {
					echo "<div class='alert alert-success alert-dismissible'>
					<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Berhasil!</strong> " . $pesan_sukses . "</div>";
				}
				?>
<!-- Tambahkan input form untuk tanggal awal dan tanggal akhir -->
<div style="margin-bottom: 10px;">
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="search_nama_toko">Cari Nama Toko</label>
            <input type="text" name="search_nama_toko" class="form-control" id="search_nama_toko" placeholder="Nama Toko" value="<?php echo isset($_GET['search_nama_toko']) ? $_GET['search_nama_toko'] : ''; ?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="search_nama_produk">Cari Nama Produk</label>
            <input type="text" name="search_nama_produk" class="form-control" id="search_nama_produk" placeholder="Nama Produk" value="<?php echo isset($_GET['search_nama_produk']) ? $_GET['search_nama_produk'] : ''; ?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="start_date">Tanggal Awal</label>
            <input type="date" name="start_date" class="form-control" id="start_date">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="end_date">Tanggal Terakhir</label>
            <input type="date" name="end_date" class="form-control" id="end_date">
        </div>
    </div>
</div>


        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
</div>

					<table class="table table-hover table-bordered">
						<tr>
							<th>Kode dropping</th>
							<th>Nama Toko</th>
							<th>Nama Produk</th>
							<th>Bulan - Tahun</th>
							<th>Jumlah Roti (pcs)</th>
						</tr>
						<?php
						$resultquery = mysqli_query($koneksi, $querytampil);

						if (!$resultquery) {
							die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
						}

						while ($data = mysqli_fetch_assoc($resultquery)) {
							?>
							<tr>
								<?php
								echo "<td>$data[kode_dropping]</td>";
								echo "<td>$data[nama_toko]</td>";
								echo "<td>$data[nama_produk]</td>";
								echo "<td>$data[bln_thn]</td>";
								echo "<td>$data[jumlah_dropping]</td>";
								?>
							</tr>
						<?php
						}

						mysqli_free_result($resultquery);

						// Menghitung total data untuk pagination
						$querytotal = "SELECT COUNT(*) as total FROM tb_dropping";
						$resulttotal = mysqli_query($koneksi, $querytotal);
						$rowtotal = mysqli_fetch_assoc($resulttotal);
						$total_pages = ceil($rowtotal['total'] / $limit);

						mysqli_close($koneksi);
						?>
					</table>
					<a href="cetak_pdf_dropping.php?search_nama_toko=<?php echo $search_nama_toko; ?>&search_nama_produk=<?php echo $search_nama_produk; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" target="_blank" class="btn btn-primary">Cetak PDF</a>



					<!-- Pagination -->
					<div class="pagination">
						<?php
						$pagelink = "";

						if ($page > 1) {
							$pagelink .= "<a href='laporan_dropping.php?page=1&search_nama_toko=$search_nama_toko&search_nama_produk=$search_nama_produk&start_date=$start_date&end_date=$end_date'>First</a>";
							$prevpage = $page - 1;
							$pagelink .= "<a href='laporan_dropping.php?page=$prevpage&search_nama_toko=$search_nama_toko&search_nama_produk=$search_nama_produk&start_date=$start_date&end_date=$end_date'>Prev</a>";
						}
						
						for ($i = max(1, $page - 3); $i <= min($page + 3, $total_pages); $i++) {
							if ($i == $page) {
								$pagelink .= "<a class='active' href='laporan_dropping.php?page=$i&search_nama_toko=$search_nama_toko&search_nama_produk=$search_nama_produk&start_date=$start_date&end_date=$end_date'>$i</a>";
							} else {
								$pagelink .= "<a href='laporan_dropping.php?page=$i&search_nama_toko=$search_nama_toko&search_nama_produk=$search_nama_produk&start_date=$start_date&end_date=$end_date'>$i</a>";
							}
						}
						
						if ($page < $total_pages) {
							$nextpage = $page + 1;
							$pagelink .= "<a href='laporan_dropping.php?page=$nextpage&search_nama_toko=$search_nama_toko&search_nama_produk=$search_nama_produk&start_date=$start_date&end_date=$end_date'>Next</a>";
						}
						
						$pagelink .= "<a href='laporan_dropping.php?page=$total_pages&search_nama_toko=$search_nama_toko&search_nama_produk=$search_nama_produk&start_date=$start_date&end_date=$end_date'>Last</a>";
						
						

						echo $pagelink;
						?>
					</div>
					<!-- End Pagination -->
				</div>
			</div>
		</div>
	</div>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</body>
<style>
.pagination {
    margin-top: 20px;
}

.pagination a {
    color: #007bff;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color 0.3s;
    border: 1px solid #ddd;
    margin-right: 5px;
}

.pagination a.active {
    background-color: #007bff;
    color: white;
}

.pagination a:hover:not(.active) {
    background-color: #ddd;
}
</style>

</html>
