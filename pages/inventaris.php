<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sima Shop - Inventaris</title>
  <!--Halaman Inventaris Sima Shop
    Menampilkan daftar barang, fitur tambah, update, hapus, dan pencarian barang.
    Data diambil dari inventaris.json dan diubah via update_stok.php.-->
  <link href="../assets/css/material-dashboard.css" rel="stylesheet">
  <link href="../assets/css/custom.css" rel="stylesheet">
  <link href="../assets/css/material-dashboard.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="g-sidenav-show bg-gray-100">
  <?php include '../components/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Tombol Tambah & Hapus Barang -->
    <button class="btn btn-outline-dark me-2" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal"> 
      <i class="bi-cart-fill me-1"></i>
      Tambah Barang
    </button>
    <button class="btn btn-outline-danger" type="button" id="deleteBtn">
      <i class="bi-trash-fill me-1"></i>
      Hapus Item
    </button>

    <!-- Tabel Inventaris dengan Pencarian Kolom -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Daftar Barang</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                      </th>
                      <th>ID</th>
                      <th>Nama Barang</th>
                      <th>Harga</th>
                      <th>Stok</th>
                      <th>Harga Baru</th>
                      <th>Tambah Stok</th>
                      <th>Aksi</th>
                    </tr>
                    <tr>
                      <td></td>
                      <td><input type="text" class="form-control form-control-sm" id="searchId" placeholder="Cari ID..."></td>
                      <td><input type="text" class="form-control form-control-sm" id="searchName" placeholder="Cari Nama..."></td>
                      <td><input type="text" class="form-control form-control-sm" id="searchPrice" placeholder="Cari Harga..."></td>
                      <td><input type="text" class="form-control form-control-sm" id="searchStock" placeholder="Cari Stok..."></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody id="productTableBody"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addProductModalLabel">Tambah Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addProductForm">
              <div class="mb-3">
                <label for="nameInput" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nameInput" placeholder="Contoh: Air Mineral 350ml" required>
              </div>
              <div class="mb-3">
                <label for="priceInput" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="priceInput" placeholder="Contoh: 3500" required>
              </div>
              <div class="mb-3">
                <label for="stockInput" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stockInput" placeholder="Contoh: 10" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="addProductBtn">Tambahkan</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      // ===================== Tabel Inventaris & Pencarian =====================
      let allProducts = [];

      // Render tabel barang dari array produk
      function renderTable(products) {
        const tbody = document.getElementById('productTableBody');
        tbody.innerHTML = '';
        products.filter(p => p.id && p.name && typeof p.price !== 'undefined' && typeof p.stock !== 'undefined')
          .forEach((product, idx) => {
            const row = `
              <tr>
                <td>
                  <div class="form-check">
                    <input class="form-check-input item-checkbox" type="checkbox" data-id="${product.id}">
                  </div>
                </td>
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>Rp. ${Number(product.price).toLocaleString('id-ID')}</td>
                <td>${product.stock}</td>
                <td>
                  <input type="number" class="form-control form-control-sm" id="newPrice-${idx}" placeholder="Harga baru">
                </td>
                <td>
                  <input type="number" class="form-control form-control-sm" id="addStock-${idx}" placeholder="Tambah stok">
                </td>
                <td>
                  <button class="btn btn-sm btn-primary" onclick="updateBarang('${product.id}', ${idx})">Update</button>
                </td>
              </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
          });
      }

      // Ambil data dari inventaris.json dan tampilkan di tabel
      function loadTable() {
        fetch('inventaris.json?' + Date.now())
          .then(res => res.json())
          .then(products => {
            if (!Array.isArray(products)) products = [];
            allProducts = products;
            renderTable(products);
          })
          .catch(err => {
            document.getElementById('productTableBody').innerHTML = '<tr><td colspan="8" class="text-center text-danger">Gagal memuat data inventaris.</td></tr>';
            console.error(err);
          });
      }

      // Filter tabel berdasarkan input pencarian kolom
      function filterTable() {
        const idVal = document.getElementById('searchId').value.trim().toLowerCase();
        const nameVal = document.getElementById('searchName').value.trim().toLowerCase();
        const priceVal = document.getElementById('searchPrice').value.trim().toLowerCase();
        const stockVal = document.getElementById('searchStock').value.trim().toLowerCase();

        const filtered = allProducts.filter(p => {
          const idMatch = p.id.toLowerCase().includes(idVal);
          const nameMatch = p.name.toLowerCase().includes(nameVal);
          const priceMatch = priceVal === "" || String(p.price).toLowerCase().includes(priceVal);
          const stockMatch = stockVal === "" || String(p.stock).toLowerCase().includes(stockVal);
          return idMatch && nameMatch && priceMatch && stockMatch;
        });
        renderTable(filtered);
      }

      // Event listener untuk input pencarian
      document.addEventListener('DOMContentLoaded', function() {
        loadTable();
        document.getElementById('searchId').addEventListener('input', filterTable);
        document.getElementById('searchName').addEventListener('input', filterTable);
        document.getElementById('searchPrice').addEventListener('input', filterTable);
        document.getElementById('searchStock').addEventListener('input', filterTable);
      });

      // ===================== Tambah Barang =====================
      // Tambah produk ke inventaris.json
      document.getElementById('addProductBtn').addEventListener('click', function() {
        const name = document.getElementById('nameInput').value.trim();
        const price = parseInt(document.getElementById('priceInput').value);
        const stock = parseInt(document.getElementById('stockInput').value);

        if (!name || isNaN(price) || isNaN(stock)) {
          alert("Harap isi semua kolom!");
          return;
        }

        fetch('inventaris.json?' + Date.now())
          .then(res => res.json())
          .then(products => {
            if (!Array.isArray(products)) products = [];
            // Cari ID terakhir
            let lastId = 0;
            products.forEach(p => {
              const match = /^BRG-(\d+)$/.exec(p.id);
              if (match) {
                const num = parseInt(match[1]);
                if (num > lastId) lastId = num;
              }
            });
            const newId = 'BRG-' + String(lastId + 1).padStart(3, '0');
            products.push({ id: newId, name, price, stock });
            return fetch('update_stok.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(products)
            });
          })
          .then(res => res ? res.json() : null)
          .then (data => {
            if (data && data.success) {
              document.getElementById('addProductForm').reset();
              const modalEl = document.getElementById('addProductModal');
              if (window.bootstrap && bootstrap.Modal.getInstance) {
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
              } else {
                modalEl.style.display = 'none';
              }
              loadTable();
            } else if (data === null) {
              alert("Gagal menambah produk! (Tidak ada respon dari server)");
            } else if (data && data.success === false) {
              alert("Gagal menambah produk! " + (data.error || ''));
            }
          })
          .catch(err => {
            alert("Terjadi kesalahan koneksi atau server!");
            console.error(err);
          });
      });

      // ===================== Update Barang =====================
      // Fungsi update barang (harga/stok)
      function updateBarang(id, idx) {
        fetch('inventaris.json?' + Date.now())
          .then(res => res.json())
          .then(products => {
            if (!Array.isArray(products)) products = [];
            const product = products.find(p => p.id === id);
            if (!product) return alert("Barang tidak ditemukan!");

            const newPrice = parseInt(document.getElementById('newPrice-' + idx).value);
            const addStock = parseInt(document.getElementById('addStock-' + idx).value);

            if (!isNaN(newPrice)) product.price = newPrice;
            if (!isNaN(addStock)) product.stock += addStock;

            return fetch('update_stok.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(products)
            });
          })
          .then(res => res ? res.json() : null)
          .then(data => {
            if (data && data.success) {
              loadTable();
            } else {
              alert("Gagal update barang!");
            }
          })
          .catch(err => {
            alert("Terjadi kesalahan koneksi atau server!");
            console.error(err);
          });
      }

      // ===================== Hapus Barang =====================
      // Hapus barang yang dicentang
      document.getElementById('deleteBtn').addEventListener('click', function() {
        const checked = Array.from(document.querySelectorAll('.item-checkbox:checked'));
        if (checked.length === 0) {
          alert("Pilih minimal satu barang yang ingin dihapus!");
          return;
        }
        if (!confirm("Yakin ingin menghapus barang terpilih?")) return;

        fetch('inventaris.json?' + Date.now())
          .then(res => res.json())
          .then(products => {
            if (!Array.isArray(products)) products = [];
            const idsToDelete = checked.map(cb => cb.getAttribute('data-id'));
            const newProducts = products.filter(p => !idsToDelete.includes(p.id));
            return fetch('update_stok.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(newProducts)
            });
          })
          .then(res => res ? res.json() : null)
          .then(data => {
            if (data && data.success) {
              loadTable();
            } else {
              alert("Gagal menghapus barang!");
            }
          })
          .catch(err => {
            alert("Terjadi kesalahan koneksi atau server!");
            console.error(err);
          });
      });

      // ===================== Checkbox Select All =====================
      document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
      });

      // Panggil loadTable saat halaman dibuka
      window.addEventListener('DOMContentLoaded', loadTable);
    </script>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="../assets/js/material-dashboard.min.js"></script>
</body>
</html>