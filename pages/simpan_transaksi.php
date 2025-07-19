<?php
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Data tidak valid']);
    exit;
}
$file = __DIR__ . '/riwayat_transaksi.json';
$riwayat = [];
if (file_exists($file)) {
    $riwayat = json_decode(file_get_contents($file), true);
    if (!is_array($riwayat)) $riwayat = [];
}
// Ambil nama kasir dari data POST (frontend)
$data['kasir'] = $data['kasir'] ?? 'Kasir';
// Simpan transaksi
$riwayat[] = $data;
if (file_put_contents($file, json_encode($riwayat, JSON_PRETTY_PRINT)) === false) {
    echo json_encode(['success' => false, 'error' => 'Gagal menulis file']);
    exit;
}
echo json_encode(['success' => true]);
?>