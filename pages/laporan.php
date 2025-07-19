<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sima Shop - Laporan Keuangan</title>
  <link href="../assets/css/material-dashboard.css" rel="stylesheet">
  <link href="../assets/css/custom.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tambahkan ini: -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="g-sidenav-show bg-gray-100">
<?php
// ====================================================================
// Halaman Laporan Keuangan Sima Shop
// Menampilkan rekap keuangan, filter tanggal, barang paling laku/tidak laku, dan detail transaksi.
// Data diambil dari inventaris.json dan riwayat_transaksi.json.
// ====================================================================

// --- Ambil data inventaris & transaksi ---
$inventaris = [];
$riwayat = [];
if (file_exists('inventaris.json')) {
    $inventaris = json_decode(file_get_contents('inventaris.json'), true);
}
if (file_exists('riwayat_transaksi.json')) {
    $riwayat = json_decode(file_get_contents('riwayat_transaksi.json'), true);
}

// --- Filter transaksi sesuai periode yang dipilih ---
$start = $_GET['start_date'] ?? '';
$end = $_GET['end_date'] ?? '';
$compareMonth = $_GET['compare_month'] ?? '';
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

// --- Rekap jumlah terjual per barang ---
$rekapBarang = [];
foreach ($inventaris as $barang) {
    if (!isset($barang['id']) || !isset($barang['name'])) continue;
    $rekapBarang[$barang['id']] = [
        'id' => $barang['id'],
        'name' => $barang['name'],
        'qty' => 0
    ];
}
foreach ($trxFiltered as $trx) {
    if (!isset($trx['barang']) || !is_array($trx['barang'])) continue;
    foreach ($trx['barang'] as $b) {
        if (isset($rekapBarang[$b['id']])) {
            $rekapBarang[$b['id']]['qty'] += $b['qty'];
        }
    }
}

// --- Barang tidak laku ---
$barangTidakLaku = array_filter($rekapBarang, function($b) {
    return $b['qty'] == 0;
});

// --- Barang paling laku (top 5) ---
$barangLaku = $rekapBarang;
usort($barangLaku, function($a, $b) {
    return $b['qty'] <=> $a['qty'];
});
$barangLaku = array_slice($barangLaku, 0, 5);

// --- Hitung total pendapatan, laba/rugi, dan total barang terjual ---
$totalPendapatan = 0;
$totalModal = 0;
$totalQty = 0;
foreach ($trxFiltered as $trx) {
    $totalPendapatan += $trx['total'] ?? 0;
    if (!isset($trx['barang']) || !is_array($trx['barang'])) continue;
    foreach ($trx['barang'] as $b) {
        $totalQty += $b['qty'];
        // Hitung modal jika ada
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

// --- Gap keuntungan bulan ini vs bulan pembanding ---
$gap = 0;
if ($compareMonth) {
    $bulanIni = date('Y-m');
    $bulanBanding = $compareMonth;
    $labaIni = 0;
    $labaBanding = 0;
    foreach ($riwayat as $trx) {
        if (!isset($trx['tanggal'])) continue;
        $bln = substr($trx['tanggal'], 0, 7);
        $trxTotal = $trx['total'] ?? 0;
        $trxModal = 0;
        if (isset($trx['barang']) && is_array($trx['barang'])) {
            foreach ($trx['barang'] as $b) {
                foreach ($inventaris as $inv) {
                    if (isset($inv['id']) && $inv['id'] == $b['id'] && isset($inv['modal'])) {
                        $trxModal += $inv['modal'] * $b['qty'];
                        break;
                    }
                }
            }
        }
        if ($bln == $bulanIni) $labaIni += ($trxTotal - $trxModal);
        if ($bln == $bulanBanding) $labaBanding += ($trxTotal - $trxModal);
    }
    $gap = $labaIni - $labaBanding;
}

// --- Fungsi format rupiah ---
function formatRupiah($angka) {
    return 'Rp. ' . number_format($angka, 0, ',', '.');
}
?>
<?php include '../components/sidebar.php'; ?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <section class="py-4">
      <div class="container-fluid px-4 px-lg-5">

        <!-- ===================== Filter Rentang Waktu ===================== -->
        <div class="card mb-4">
          <div class="card-header fw-bold">Filter Laporan</div>
          <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
              <div class="col-md-3">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
              </div>
              <div class="col-md-3">
                <label for="end_date" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
              </div>
              <div class="col-md-3">
                <label for="compare_month" class="form-label">Bandingkan dengan Bulan</label>
                <select class="form-select" id="compare_month" name="compare_month">
                  <option value="">-- Pilih Bulan --</option>
                  <?php
                    $now = new DateTime();
                    for ($i = 0; $i < 12; $i++) {
                      $monthValue = $now->format('Y-m');
                      $bulanIndo = [
                        'January'=>'Januari','February'=>'Februari','March'=>'Maret','April'=>'April','May'=>'Mei','June'=>'Juni',
                        'July'=>'Juli','August'=>'Agustus','September'=>'September','October'=>'Oktober','November'=>'November','December'=>'Desember'
                      ];
                      $bln = $now->format('F');
                      $monthLabel = ($bulanIndo[$bln] ?? $bln) . ' ' . $now->format('Y');
                      $selected = (isset($_GET['compare_month']) && $_GET['compare_month'] == $monthValue) ? 'selected' : '';
                      echo "<option value=\"$monthValue\" $selected>$monthLabel</option>";
                      $now->modify('-1 month');
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-pill shadow-sm" style="font-weight:600;font-size:1rem;">
                  <span class="material-symbols-rounded me-1" style="font-size:1.3rem;">search</span>
                  Tampilkan Laporan
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- ===================== Ringkasan Keuangan ===================== -->
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">Ringkasan Keuangan</span>
            <a href="cetak_laporan.php?start_date=<?= $_GET['start_date'] ?? '' ?>&end_date=<?= $_GET['end_date'] ?? '' ?>" target="_blank"
              class="btn btn-outline-primary btn-sm d-flex align-items-center rounded-pill shadow-sm" style="font-weight:600;font-size:1rem;">
              <span class="material-symbols-rounded me-1" style="font-size:1.3rem;">print</span>
              Cetak PDF
            </a>
          </div>
          <div class="card-body">
            <table class="table table-bordered mb-0">
              <tbody>
                <tr>
                  <th>Total Pendapatan</th>
                  <td><?= formatRupiah($totalPendapatan); ?></td>
                </tr>
                <tr>
                  <th>Laba/Rugi</th>
                  <td class="<?= $laba > 0 ? 'text-success' : ($laba < 0 ? 'text-danger' : 'text-secondary') ?>">
                    <?php if ($laba > 0): ?>
                      <i class="fa fa-arrow-up"></i> <?= formatRupiah($laba); ?>
                    <?php elseif ($laba < 0): ?>
                      <i class="fa fa-arrow-down"></i> <?= formatRupiah($laba); ?>
                    <?php else: ?>
                      <i class="fa fa-minus"></i> <?= formatRupiah($laba); ?>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th>Total Barang Terjual</th>
                  <td><?= $totalQty ?> Item</td>
                </tr>
                <tr>
                  <th>Gap Keuntungan Bulan Ini vs Bulan Lalu</th>
                  <td class="<?= $gap > 0 ? 'text-success' : ($gap < 0 ? 'text-danger' : 'text-secondary') ?>">
                    <?php if ($gap > 0): ?>
                      <i class="fa fa-arrow-up"></i> <?= formatRupiah($gap); ?>
                    <?php elseif ($gap < 0): ?>
                      <i class="fa fa-arrow-down"></i> <?= formatRupiah($gap); ?>
                    <?php else: ?>
                      <i class="fa fa-minus"></i> <?= formatRupiah($gap); ?>
                    <?php endif; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ===================== Rekap Barang Paling Laku & Tidak Laku ===================== -->
        <div class="row">
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-header fw-bold bg-success text-white">Barang Paling Laku</div>
              <div class="card-body p-0">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Jumlah Terjual</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($barangLaku as $b): ?>
                      <tr>
                        <td><?= htmlspecialchars($b['name']) ?></td>
                        <td><?= $b['qty'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-header fw-bold bg-danger text-white">Barang Paling Tidak Laku</div>
              <div class="card-body p-0">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Jumlah Terjual</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($barangTidakLaku) > 0): ?>
                      <?php foreach ($barangTidakLaku as $b): ?>
                        <tr class="text-danger fw-bold">
                          <td><?= htmlspecialchars($b['name']) ?></td>
                          <td>0</td>
                          <td><span title="Tidak ada penjualan"><i class="fa fa-ban"></i> Tidak Laku</span></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="3" class="text-center text-success">Semua barang terjual pada periode ini.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- ===================== Tabel Detail Transaksi ===================== -->
        <div class="card mb-4">
          <div class="card-header fw-bold">Detail Transaksi</div>
          <div class="card-body p-0">
            <table class="table table-bordered mb-0">
              <thead class="table-light">
                <tr>
                  <th>No. Transaksi</th>
                  <th>Tanggal</th>
                  <th>Barang</th>
                  <th>Total</th>
                  <th>Kasir</th>
                  <th>Metode</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($trxFiltered) > 0): ?>
                  <?php foreach ($trxFiltered as $trx): ?>
                    <tr>
                      <td><?= htmlspecialchars($trx['id']) ?></td>
                      <td><?= htmlspecialchars($trx['tanggal']) ?></td>
                      <td>
                        <?php foreach ($trx['barang'] as $b): ?>
                          <?= htmlspecialchars($b['nama']) ?> (<?= $b['qty'] ?>)<br>
                        <?php endforeach; ?>
                      </td>
                      <td><?= formatRupiah($trx['total']) ?></td>
                      <td><?= htmlspecialchars($trx['kasir']) ?></td>
                      <td><?= htmlspecialchars($trx['metode']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-secondary">Tidak ada transaksi pada periode ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </main>
</body>
</html>