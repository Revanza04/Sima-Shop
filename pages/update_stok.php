<?php
// API untuk update inventaris.json dari permintaan POST (JSON)
// Digunakan oleh halaman kasir & inventaris untuk update stok/harga barang

$data = json_decode(file_get_contents('php://input'), true);
if (is_array($data)) {
  $result = file_put_contents('../pages/inventaris.json', json_encode($data, JSON_PRETTY_PRINT));
  if ($result !== false) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'error' => 'Gagal menulis file']);
  }
} else {
  echo json_encode(['success' => false, 'error' => 'Data tidak valid']);
}
?>



