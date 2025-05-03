<?php

include_once("koneksi.php");

if (isset($_POST["submit"])) {

	if ($_POST["submit"]=="Hapus") {

		$id = htmlentities(strip_tags(trim($_POST["kode_retur"])));
		$id = mysqli_real_escape_string($koneksi,$id);

		$queryhapus = "delete from tb_retur1 where kode_retur = '$id'";
		$resultquery = mysqli_query($koneksi,$queryhapus);

		if ($resultquery) {
			$pesan_sukses = "retur berhasil dihapus";
			$pesan_sukses = urlencode($pesan_sukses);
			header("Location: data_retur.php?pesan_sukses={$pesan_sukses}");
		}
		else {
			die("Query gagal dijalankan: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
		}

	}
	mysqli_free_result($resultquery);
	mysqli_close($koneksi);
}
else {
	header("Location: data_retur.php");
}

mysqli_free_result($resultquery);
mysqli_close($koneksi);
?>