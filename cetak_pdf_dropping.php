<?php
require('fpdf/fpdf.php');
include_once("koneksi.php");

$search_nama_toko = isset($_GET['search_nama_toko']) ? $_GET['search_nama_toko'] : '';
$search_nama_produk = isset($_GET['search_nama_produk']) ? $_GET['search_nama_produk'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

class PDF extends FPDF
{
    function Header()
    {
        // Judul halaman
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Daftar Data Dropping Roti ', 0, 1, 'C');
        
        // Tabel Header
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'Kode', 1);
        $this->Cell(40, 10, 'Nama Toko', 1);
        $this->Cell(60, 10, 'Nama Produk', 1);
        $this->Cell(30, 10, 'Bulan - Tahun', 1);
        $this->Cell(30, 10, 'Jumlah Roti (pcs)', 1);
        $this->Ln();
    }

    function Footer()
    {
        // Tampilkan halaman
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Membuat objek PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$querytampil = "SELECT tb_dropping.kode_dropping, tb_dropping.nama_toko, tb_produk.nama_produk, tb_dropping.bln_thn, tb_dropping.jumlah_dropping FROM tb_dropping
INNER JOIN tb_produk ON tb_dropping.kode_produk = tb_produk.kode_produk WHERE 1";

if (!empty($search_nama_toko)) {
    $querytampil .= " AND tb_dropping.nama_toko LIKE '%$search_nama_toko%'";
}

if (!empty($search_nama_produk)) {
    $querytampil .= " AND tb_produk.nama_produk LIKE '%$search_nama_produk%'";
}

if (!empty($start_date) && !empty($end_date)) {
    $querytampil .= " AND tb_dropping.bln_thn BETWEEN '$start_date' AND '$end_date'";
} elseif (!empty($start_date)) {
    $querytampil .= " AND tb_dropping.bln_thn >= '$start_date'";
} elseif (!empty($end_date)) {
    $querytampil .= " AND tb_dropping.bln_thn <= '$end_date'";
}

// Lanjutkan dengan menjalankan query dan mencetak PDF


$resultquery = mysqli_query($koneksi, $querytampil);

if (!$resultquery) {
    die("Query Error : " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
}

while ($data = mysqli_fetch_assoc($resultquery)) {
    $pdf->Cell(20, 10, $data['kode_dropping'], 1);
    // $pdf->Cell(40, 10, $data['nama_toko'], 1);
    $pdf->Cell(60, 10, $data['nama_produk'], 1);
    $pdf->Cell(30, 10, $data['bln_thn'], 1);
    $pdf->Cell(30, 10, $data['jumlah_dropping'], 1);
    $pdf->Ln();
}

mysqli_free_result($resultquery);
mysqli_close($koneksi);

// Menyimpan PDF sebagai file
$pdf->Output('Daftar_Data_Dropping_Roti.pdf', 'D');
?>
