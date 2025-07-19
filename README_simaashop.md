# Sima Shop

Sima Shop adalah aplikasi web kasir sederhana berbasis PHP yang **tidak menggunakan database SQL**, melainkan menyimpan data dalam file **JSON**. Proyek ini cocok untuk pembelajaran, tugas sekolah, atau referensi sistem kasir toko kecil.

---

## Apa Itu Sima Shop?

Sima Shop adalah aplikasi kasir toko yang bisa dijalankan di komputer lokal (offline) tanpa perlu database seperti MySQL. Semua data barang, transaksi, dan laporan disimpan dalam file JSON. Aplikasi ini dibuat agar mudah dipelajari, dimodifikasi, dan digunakan untuk latihan membuat sistem kasir.

---

## Fitur Utama

- **Dashboard**  
  Melihat ringkasan pemasukan, stok menipis, grafik penjualan, dan pengguna terakhir online.
- **Manajemen Inventaris**  
  Tambah, edit, hapus barang, dan update stok/harga.
- **Kasir**  
  Pilih produk, tambah ke keranjang, checkout, dan simpan transaksi.
- **Manajemen Pengguna**  
  Tambah, edit, hapus pengguna (data pengguna hanya disimpan di browser, bukan di server).
- **Riwayat Transaksi**  
  Lihat dan hapus transaksi yang pernah terjadi.
- **Laporan Keuangan**  
  Filter laporan, rekap penjualan, barang terlaris, barang tidak laku, dan cetak PDF.

---

## Cara Kerja & Penyimpanan Data

- **Data barang dan transaksi** disimpan di file JSON (`inventaris.json`, `riwayat_transaksi.json`) yang bisa diakses dan diubah langsung oleh PHP.
- **Tidak menggunakan database SQL** seperti MySQL atau PostgreSQL.
- **Data pengguna** (untuk login) disimpan di localStorage browser, bukan di server. Jika data pengguna di browser hilang, login tidak bisa dilakukan.

---

## Cara Menjalankan

1. **Clone atau download** project ini ke server lokal anda (misal: Laragon, XAMPP, dsb).
2. Pastikan folder `pages/` berisi file `inventaris.json` dan `riwayat_transaksi.json` (bisa kosong).
3. Buka `http://localhost/Sima%20Shop/` di browser.
4. **Login** menggunakan data pengguna yang sudah ada di localStorage browser.

---

## Tidak Bisa Login?

Karena aplikasi ini **tidak menggunakan database**, jika data pengguna di localStorage browser kosong atau belum ada, maka halaman login tidak bisa digunakan.

**Solusi cepat:**  
Langsung akses dashboard tanpa login melalui link berikut:  
[http://localhost/Sima%20Shop/pages/dashboard.php](http://localhost/Sima%20Shop/pages/dashboard.php)

---

## Struktur Folder

```
Sima Shop/
│
├── assets/
│   └── css/
│       ├── material-dashboard.css
│       ├── custom.css
│       └── login-style.css
│
├── components/
│   └── sidebar.php
│
├── pages/
│   ├── dashboard.php
│   ├── inventaris.php
│   ├── kasir.php
│   ├── laporan.php
│   ├── pengguna.php
│   ├── riwayat-transaksi.php
│   ├── cetak_laporan.php
│   ├── update_stok.php
│   ├── simpan_transaksi.php
│   ├── inventaris.json
│   └── riwayat_transaksi.json
│
├── index.php
└── README.md
```

---

## Catatan

- **Tidak ada autentikasi database**: semua data pengguna hanya di browser.
- **Cocok untuk belajar CRUD, manajemen data, dan laporan berbasis web.**
- Jika ingin login, pastikan sudah ada data pengguna di localStorage browser. Jika tidak, gunakan link bypass dashboard di atas.

---

## Lisensi

Bebas digunakan untuk pembelajaran dan pengembangan pribadi.