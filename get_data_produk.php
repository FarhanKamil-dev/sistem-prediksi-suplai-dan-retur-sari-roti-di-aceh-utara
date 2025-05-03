<?php
// get_data_produk.php

include_once("koneksi.php");

if (isset($_POST['selected_produk'])) {
    $selectedProduk = $_POST['selected_produk'];

    $querytampil = "SELECT p.nama_produk, r.bln_thn, SUM(r.jumlah_retur) AS jumlah_retur
                    FROM tb_retur1 r
                    JOIN tb_produk p ON r.kode_produk = p.kode_produk
                    WHERE r.nama_toko = 'kardana' AND p.nama_produk = ?
                    GROUP BY p.nama_produk, r.bln_thn";

    $stmt = mysqli_prepare($koneksi, $querytampil);
    mysqli_stmt_bind_param($stmt, "s", $selectedProduk);
    mysqli_stmt_execute($stmt);
    $resultquery = mysqli_stmt_get_result($stmt);

    if (!$resultquery) {
        die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    }

    while ($row = mysqli_fetch_assoc($resultquery)) {
        echo "<tr>";
        echo "<td>{$row['bln_thn']}</td>
            <td>{$row['jumlah_retur']}</td>";
        echo "</tr>";
    }

    mysqli_free_result($resultquery);
    mysqli_close($koneksi);
}
?>
