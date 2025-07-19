<?php
// Halaman Cetak Laporan Keuangan Sima Shop
// Mengambil data transaksi dan inventaris, lalu menghasilkan laporan PDF menggunakan mPDF

require_once __DIR__ . '/../vendor/autoload.php'; // Pastikan path ke autoload mPDF benar

// --- Ambil data laporan dari file JSON ---
$inventaris = [];
$riwayat = [];
if (file_exists('inventaris.json')) {
    $inventaris = json_decode(file_get_contents('inventaris.json'), true);
}
if (file_exists('riwayat_transaksi.json')) {
    $riwayat = json_decode(file_get_contents('riwayat_transaksi.json'), true);
}

// --- Filter transaksi berdasarkan tanggal yang dipilih user ---
$start = $_GET['start_date'] ?? '';
$end = $_GET['end_date'] ?? '';
$trxFiltered = [];
foreach ($riwayat as $trx) {
    if (!isset($trx['tanggal'])) continue;
    $tgl = $trx['tanggal'];
    if (
        (!$start || $tgl >= $start) &&
        (!$end || $tgl <= $end)
    ) {
        $trxFiltered[] = $trx;
    }
}

// --- Hitung total pendapatan, modal, qty, dan laba ---
$totalPendapatan = 0;
$totalModal = 0;
$totalQty = 0;
foreach ($trxFiltered as $trx) {
    $totalPendapatan += $trx['total'] ?? 0;
    if (!isset($trx['barang']) || !is_array($trx['barang'])) continue;
    foreach ($trx['barang'] as $b) {
        $totalQty += $b['qty'];
        $modal = 0;
        foreach ($inventaris as $inv) {
            if (isset($inv['id']) && $inv['id'] == $b['id'] && isset($inv['modal'])) {
                $modal = $inv['modal'] * $b['qty'];
                break;
            }
        }
        $totalModal += $modal;
    }
}
$laba = $totalPendapatan - $totalModal;

// Fungsi format rupiah
function formatRupiah($angka) {
    return 'Rp. ' . number_format($angka, 0, ',', '.');
}

// --- Data toko & waktu cetak ---
$namaToko = "Sima Shop";
$logoPath = __DIR__ . '/../images/simashopdark.png'; // Ganti sesuai lokasi logo
$logoBase64 = '';
if (file_exists($logoPath)) {
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
}
date_default_timezone_set('Asia/Jakarta');
$hariIndo = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$waktuCetak = $hariIndo[date('w')] . ', ' . date('d') . ' ' . $bulanIndo[(int)date('m')] . ' ' . date('Y') . ' - ' . date('H:i:s');

// --- HTML untuk PDF, berisi ringkasan dan tabel transaksi ---
$html = '
<style>
    .judul-laporan { text-align:center; margin-bottom:10px; }
    .logo-toko { width:60px; height:60px; object-fit:contain; }
    .info-cetak { font-size:12px; text-align:right; margin-bottom:10px; }
    .table { border-collapse:collapse; width:100%; margin-bottom:10px; }
    .table th, .table td { border:1px solid #333; padding:6px 8px; font-size:13px; }
    .table th { background:#eee; }
</style>
<div class="judul-laporan">
    '.($logoBase64 ? '<img src="'.$logoBase64.'" class="logo-toko"><br>' : '').'
    <span style="font-size:22px;font-weight:bold">'.$namaToko.'</span><br>
    <span style="font-size:16px;">Laporan Keuangan</span>
</div>
<div class="info-cetak">
    Dicetak: '.$waktuCetak.'
</div>
<table class="table">
    <tr>
        <th>Total Pendapatan</th>
        <td>'.formatRupiah($totalPendapatan).'</td>
    </tr>
    <tr>
        <th>Laba/Rugi</th>
        <td>'.formatRupiah($laba).'</td>
    </tr>
    <tr>
        <th>Total Barang Terjual</th>
        <td>'.$totalQty.' Item</td>
    </tr>
</table>
<table class="table">
    <thead>
        <tr>
            <th>No. Transaksi</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Total</th>
            <th>Metode</th>
        </tr>
    </thead>
    <tbody>';
if (count($trxFiltered) > 0) {
    foreach ($trxFiltered as $trx) {
        $barangList = '';
        foreach ($trx['barang'] as $b) {
            $barangList .= htmlspecialchars($b['nama']) . ' ('.$b['qty'].')<br>';
        }
        $html .= '<tr>
            <td>'.htmlspecialchars($trx['id']).'</td>
            <td>'.htmlspecialchars($trx['tanggal']).'</td>
            <td>'.$barangList.'</td>
            <td>'.formatRupiah($trx['total']).'</td>
            <td>'.htmlspecialchars($trx['metode']).'</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center;color:#888;">Tidak ada transaksi pada periode ini.</td></tr>';
}
$html .= '
    </tbody>
</table>
';

// --- Generate PDF menggunakan mPDF ---
$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan-Penjualan-'.date('Ymd-His').'.pdf', 'I');
exit;
?>