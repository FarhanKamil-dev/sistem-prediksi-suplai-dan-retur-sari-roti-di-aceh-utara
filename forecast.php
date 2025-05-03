<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include_once("koneksi.php");

$querytampil = "SELECT p.nama_produk, r.bln_thn, SUM(r.jumlah_retur) AS jumlah_retur
                FROM tb_retur1 r
                JOIN tb_produk p ON r.kode_produk = p.kode_produk
                WHERE r.nama_toko = 'kardana'
                GROUP BY p.nama_produk, r.bln_thn";


$queryalpha = "SELECT * FROM tb_alpha WHERE id_alpha = 'A1'";
$querysum = "SELECT SUM(r.jumlah_retur) AS jumlah_retur 
FROM tb_retur1 r 
JOIN tb_produk p ON r.kode_produk = p.kode_produk 
WHERE r.nama_toko = 'kardana' 
GROUP BY p.nama_produk";

$pesan_error = "";

if (isset($_GET['pesan_sukses'])) {
    $pesan_sukses = $_GET['pesan_sukses'];
}

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Ganti Alpha") {
        $id_alpha = htmlentities(strip_tags(trim($_POST['id_alpha'])));
        $n_alpha = htmlentities(strip_tags(trim($_POST['nilai_alpha'])));

        $pesan_error = "";

        if (empty($n_alpha)) {
            $pesan_error = "Nilai alpha belum diisi!";
        }

        if (($pesan_error === "") && ($_POST["submit"] == "Ganti Alpha")) {
            $id_alpha = mysqli_real_escape_string($koneksi, $id_alpha);
            $n_alpha = mysqli_real_escape_string($koneksi, $n_alpha);

            $queryupdatealpha = "UPDATE tb_alpha SET nilai_alpha = '$n_alpha' WHERE id_alpha = '$id_alpha'";

            $resultquery = mysqli_query($koneksi, $queryupdatealpha);

            if ($resultquery) {
                $pesan_sukses = "Alpha berhasil diupdate!<br>";
                $pesan_sukses = urlencode($pesan_sukses);
                header("Location: forecast.php?pesan_sukses={$pesan_sukses}");
                exit;
            } else {
                die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
            }

            mysqli_free_result($resultquery);
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forecasting - Sari Roti</title>
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
                <h2 style="margin-bottom: 25px;">A. Data Peramalan Bulan Berikutnya</h2>
                <div style="margin-bottom: 10px;">
                    <?php
                    if ($pesan_error !== "") {
                        echo "<div class='alert alert-danger alert-dismissible'>
                        <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Gagal!</strong> " . $pesan_error .
                            "</div>";
                    }

                    if (isset($pesan_sukses)) {
                        echo "<div class='alert alert-success alert-dismissible'>
                        <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Berhasil!</strong> " . $pesan_sukses .
                            "</div>";
                    }

                    $resultquery = mysqli_query($koneksi, $queryalpha);

                    if (!$resultquery) {
                        die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
                    }

                    $data_alpha = mysqli_fetch_assoc($resultquery);
                    ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="alert alert-info">Nilai alpha saat ini adalah : <b><?php echo $data_alpha['nilai_alpha']; ?></b></h6>
                        </div>
                        <div class="col-sm-8">
                            <form action="forecast.php" method="post" name="ubah_alpha">
                                <div class="form-check form-check-inline">
                                    <input class="form-control" type="text" name="nilai_alpha" placeholder="Ganti Nilai Alpha" style="width:400px;">
                                    <input type="hidden" name="id_alpha" value="<?php echo $data_alpha['id_alpha']; ?>">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Ganti Alpha" style="margin-left:10px;">
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
                <?php 
                $produk = "";
                if (isset($_POST['filter'])) {
                    $produk = $_POST['produk'];
                }
		        ?>
                    <div class="col-sm-6">
                        <form action="forecast.php" method="get">
                        <div class="form-group">
					<select name="produk" id="produk" class="form-control">
							<option value="">--Pilih Produk--</option>
							<option value="BAUMKUCHEN COKELAT" <?php if ($produk=="BAUMKUCHEN COKELAT") { echo "selected"; } ?>>BAUMKUCHEN COKELAT</option>
							<option value="BAUMKUCHEN ORIGINAL" <?php if ($produk=="BAUMKUCHEN ORIGINAL") { echo "selected"; } ?>>BAUMKUCHEN ORIGINAL</option>

						</select>
					</div>
				
                        </div>
                        <div class="col-sm-4">
                            <button id="filter" name="filter" class="btn btn-warning">Cari</button>
                        </div>
                    </div>
                </form>
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Bulan - Tahun</th>
                                <th>Data Aktual</th>
                                <th>Data Perkiraan</th>
                                <th>Error</th>
                                <th>Abs Error</th>
                                <th>Abs Error^2</th>
                                <th>Abs Error %</th>
                            </tr>
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

                                    // if ($res1->num_rows > 0) {
                                    //     while ($row = $res1->fetch_assoc()) {
                                    //         $nama_produk = $row['nama_produk'];
                                    //         $bln_thn = $row['bln_thn'];
                                    //         $jumlah_retur = $row['jumlah_retur'];
                                    //         $d_perkiraan = 3;
                                    //         $error = 3;
                                    //         $abs_err = 3;
                                    //         $abs_err2 = 3;
                                    //         $abs_err_percent = 3;

                                    ?>
                            <?php

                            $stmt = mysqli_prepare($koneksi, $querytampil);
                            if ($stmt) {
                                if (!empty($selected_nama_produk)) {
                                    mysqli_stmt_bind_param($stmt, "s", $selected_nama_produk);
                                }
                                mysqli_stmt_execute($stmt);
                                $resultquery = mysqli_stmt_get_result($stmt);

                                if (!$resultquery) {
                                    die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
                                }

                                // Bagian kode lainnya...
                            } else {
                                die("Gagal menyiapkan pernyataan: " . mysqli_error($koneksi));
                            }

                            $resultsum = mysqli_query($koneksi, $querysum);
                            $hasilsum = mysqli_fetch_row($resultsum);

                            $d_perkiraan = "";
                            $count = mysqli_num_rows($resultquery);
                            $loop = 0;
                            $sum_abs_err = 0;
                            $sum_abs_err2 = 0;
                            $sum_abs_err_percent = 0;

                            while ($row = mysqli_fetch_assoc($resultquery)) {
                                // Inisiasi data perkiraan pertama
                                if ($d_perkiraan === "") {
                                    if ($count > 0) {
                                        $d_perkiraan = $hasilsum[0] / $count;
                                    } else {
                                        $d_perkiraan = 0;
                                    }
                                } else {
                                    $d_perkiraan = $h_perkiraan;
                                }

                                $array_perkiraan[] = $d_perkiraan;

                                // Rumus error
                                $error = $row['jumlah_retur'] - $d_perkiraan;

                                // Rumus absolute error
                                $abs_err = abs($error);
                                $sum_abs_err = $sum_abs_err + $abs_err;

                                // Rumus absolute error pangkat 2
                                $abs_err2 = pow($error, 2);
                                $sum_abs_err2 = $sum_abs_err2 + $abs_err2;

                                // Rumus absolute error %
                                if ($row['jumlah_retur'] != 0) {
                                    $abs_err_percent = abs((($row['jumlah_retur'] - $d_perkiraan) / $row['jumlah_retur']) * 100);
                                } else {
                                    $abs_err_percent = 0;
                                }
                                $sum_abs_err_percent = $sum_abs_err_percent + $abs_err_percent;

                                echo "<tr>";
                                echo "<td>{$row['nama_produk']}</td>";
                                echo "<td>{$row['bln_thn']}</td>
                                <td>{$row['jumlah_retur']}</td>
                                <td>" . number_format($d_perkiraan, 3) . "</td>
                                <td>" . number_format($error, 3) . "</td>
                                <td>" . number_format($abs_err, 3) . "</td>
                                <td>" . number_format($abs_err2, 3) . "</td>
                                <td>" . number_format($abs_err_percent, 3) . "%</td>";
                                echo "</tr>";
                                

                                // Rumus single exponential smoothing
                                $h_perkiraan = $d_perkiraan + $n_alpha * ($row['jumlah_retur'] - $d_perkiraan);

                                // Jika data sudah ditampilkan semua, lakukan peramalan untuk bulan berikutnya
                                $loop = $loop + 1;
                                if ($loop == $count) {
                                    echo "</table></div>";
                                    $d_aktual_next = $row['jumlah_retur'];
                                    $d_perkiraan_next = $d_perkiraan;
                                    $d_ft = $d_perkiraan_next + $n_alpha * ($d_aktual_next - $d_perkiraan_next);

                                    // Rumus MAPE
                                    $rata_abs_error_percent = $sum_abs_err_percent / $count;

                                    // Rumus rata2 abs_err MAD
                                    $rataabs_err = $sum_abs_err / $count;

                                    // Rumus rata2 abs_err2 MSD
                                    $rataabs_err2 = $sum_abs_err2 / $count;
                                    ?>
                                    <div class="col-sm-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 style="margin-left: 20px;">MAPE : <?php echo number_format($rata_abs_error_percent, 3); ?></h5>
                                                <h5 style="margin-left: 20px;">MAD : <?php echo number_format($rataabs_err, 3); ?></h5>
                                                <h5 style="margin-left: 20px;">MSD : <?php echo number_format($rataabs_err2, 3); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="alert alert-info">Perkiraan untuk bulan berikutnya adalah <?php echo number_format($d_ft, 3); ?></h4>
                                <?php
                                }
                            }
                            ?>
                        </table>
                        

                        <h2 style="margin-bottom: 25px; margin-top: 50px;">B. Grafik Peramalan Bulan Berikutnya</h2>
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
                                    $querydaktual = "SELECT p.nama_produk, SUM(r.jumlah_retur) AS jumlah_retur
                                    FROM tb_retur1 r
                                    JOIN tb_produk p ON r.kode_produk = p.kode_produk
                                    WHERE r.nama_toko = 'kardana' AND p.nama_produk = ?
                                    GROUP BY p.nama_produk, r.bln_thn";

                                    if (!$resultquery) {
                                        die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
                                    }

                                    while ($data_aktual = mysqli_fetch_assoc($resultquery)) {
                                        echo "{$data_aktual['jumlah_retur']}, ";
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
                                        echo "{$arper}, ";
                                    }
                                    echo "{$d_ft}";
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
                                    $querybulan = "SELECT p.nama_produk, SUM(r.jumlah_retur) AS jumlah_retur
                                    FROM tb_retur1 r
                                    JOIN tb_produk p ON r.kode_produk = p.kode_produk
                                    WHERE r.nama_toko = 'kardana' AND p.nama_produk = ?
                                    GROUP BY p.nama_produk, r.bln_thn";

                                    if (!$resultquery) {
                                        die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
                                    }

                                    while ($data_bulan = mysqli_fetch_assoc($resultquery)) {
                                        echo "\"{$data_bulan['bln_thn']}\", ";
                                    }
                                    echo "\"Bulan berikutnya\"";
                                    ?>],

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
        </div>
        <!-- partial -->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
    </body>
</html>
