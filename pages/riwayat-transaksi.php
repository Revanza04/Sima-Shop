<?php
// --- PROSES HAPUS DI PALING ATAS ---
// Halaman Riwayat Transaksi Sima Shop
// Menampilkan daftar transaksi, fitur hapus transaksi terpilih, dan pencarian barang yang laku.
$file = __DIR__ . '/riwayat_transaksi.json';
$riwayat = [];
if (file_exists($file)) {
    $riwayat = json_decode(file_get_contents($file), true);
    if (!is_array($riwayat)) $riwayat = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id']) && is_array($_POST['hapus_id'])) {
    $hapusIds = $_POST['hapus_id'];
    $riwayat = array_filter($riwayat, function($trx) use ($hapusIds) {
        return !in_array($trx['id'], $hapusIds);
    });
    file_put_contents($file, json_encode(array_values($riwayat), JSON_PRETTY_PRINT));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sima Shop - Riwayat Transaksi</title>
  <!--
    Halaman Riwayat Transaksi Sima Shop
    Menampilkan daftar transaksi, fitur hapus transaksi terpilih, dan pencarian barang yang laku.
  -->
  <link href="../assets/css/material-dashboard.css" rel="stylesheet">
  <link href="../assets/css/custom.css" rel="stylesheet">
  <link href="../assets/css/material-dashboard.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
  <script src="../assets/js/material-dashboard.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="g-sidenav-show bg-gray-100">
  <?php include '../components/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row justify-content-center">
        <div class="col-12 col-xxl-12">
          <div class="card my-4 shadow-sm">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
                <h5 class="text-white text-capitalize mb-0">Daftar Informasi Riwayat Transaksi</h5>
              </div>
            </div>
            <div class="card-body px-4 pb-3">
              <form method="post" id="formHapus" onsubmit="return confirm('Yakin ingin menghapus transaksi terpilih?');">
                <div class="d-flex justify-content-end mb-3">
                  <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 shadow-sm" id="btnHapus" disabled>
                    <span class="material-symbols-rounded align-middle me-1" style="font-size:1.2rem;">delete</span>
                    Hapus Terpilih
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-items-center mb-0 rounded-3 overflow-hidden">
                    <thead>
                      <tr>
                        <th style="width:36px;"><input type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id Transaksi</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Item</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Barang yang Laku</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kasir</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
if (!$riwayat || !is_array($riwayat)) {
    echo '<tr><td colspan="7" class="text-center text-secondary py-5">
      <img src="../images/empty-state.svg" alt="Kosong" style="width:70px;opacity:.5"><br>
      <span>Belum ada transaksi.</span>
    </td></tr>';
} else {
    foreach ($riwayat as $idx => $trx) {
        $barangList = '';
        if (!empty($trx['barang']) && is_array($trx['barang'])) {
            $barangList = implode(', ', array_map(function($b) {
                return htmlspecialchars($b['nama']) . ' (' . $b['qty'] . ')';
            }, $trx['barang']));
        }
        echo '<tr>
            <td><input type="checkbox" name="hapus_id[]" value="'.htmlspecialchars($trx['id']).'" class="cbHapus" onclick="toggleBtn()"></td>
            <td><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class="mb-0 text-sm">'.htmlspecialchars($trx['id']).'</h6></div></div></td>
            <td><p class="text-xs font-weight-bold mb-0">'.htmlspecialchars($trx['jumlah']).'</p></td>
            <td><p class="text-xs mb-0">'.$barangList.'</p></td>
            <td class="align-middle text-center text-sm"><p class="text-xs font-weight-bold mb-0">'.htmlspecialchars($trx['tanggal']).'</p></td>
            <td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">Rp. '.number_format($trx['total'],0,',','.').'</span></td>
            <td class="align-middle text-center"><span class="text-xs">'.htmlspecialchars($trx['kasir'] ?? '-').'</span></td>
        </tr>';
    }
}
?>
                    </tbody>
                  </table>
                </div>
              </form>
              <script>
              // Checkbox: Pilih semua transaksi
              function toggleAll(source) {
                let cbs = document.querySelectorAll('.cbHapus');
                cbs.forEach(cb => cb.checked = source.checked);
                toggleBtn();
              }
              // Aktifkan tombol hapus jika ada yang dicentang
              function toggleBtn() {
                let cbs = document.querySelectorAll('.cbHapus');
                let btn = document.getElementById('btnHapus');
                btn.disabled = !Array.from(cbs).some(cb => cb.checked);
              }
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>