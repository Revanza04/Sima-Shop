<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sima Shop - Kasir</title>
  <!-- CSS Material Dashboard -->
  <link href="../assets/css/material-dashboard.css" rel="stylesheet">
  <link href="../assets/css/custom.css" rel="stylesheet">
  <link href="../assets/css/material-dashboard.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="g-sidenav-show bg-gray-100">
  <?php include '../components/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Tombol Checkout & Search -->
    <div class="container-fluid px-3 pt-4">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div class="input-group" style="max-width:320px;">
              <span class="input-group-text bg-white border-end-0">
                <span class="material-symbols-rounded">search</span>
              </span>
              <input type="text" class="form-control border-start-0" id="searchProduct" placeholder="Cari produk...">
            </div>
            <button class="btn btn-outline-dark d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#checkoutModal">
              <span class="material-symbols-rounded me-1" style="font-size:1.5rem;">shopping_cart</span>
              <span>Checkout</span>
              <span class="badge bg-dark text-white ms-2 rounded-pill" id="cart-count">0</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Daftar Produk Dinamis -->
    <section class="py-4">
      <div class="container px-2 px-lg-3 mt-2">
        <div class="row gx-2 gx-md-3 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 justify-content-start" id="productList">
          <!-- Produk akan dimuat di sini -->
        </div>
      </div>
    </section>

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="checkoutModalLabel">Keranjang Belanja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Daftar Barang dalam Keranjang -->
            <div id="cartItems" class="mb-4"></div>

            <!-- Ringkasan Pesanan -->
            <div class="border-top pt-3">
              <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Ringkasan Pesanan</h6>
              <div class="d-flex justify-content-between mb-2">
                <span>Jumlah Item:</span>
                <span id="totalItems">0</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Total Harga:</span>
                <span id="totalPrice">Rp. 0</span>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="resetCart()">Reset Keranjang</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="confirmCheckout()">Konfirmasi Checkout</button>
          </div>
        </div>
      </div>
    </div>

<?php
$products = [];
if (file_exists('../pages/inventaris.json')) {
  $products = json_decode(file_get_contents('../pages/inventaris.json'), true);
}
?>
<script>
const products = <?php echo json_encode($products); ?>;
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let searchQuery = "";

// Tampilkan produk dengan filter pencarian
function buildProductList() {
  const productList = document.getElementById('productList');
  productList.innerHTML = '';
  let filtered = products.filter(product =>
    product.name.toLowerCase().includes(searchQuery.toLowerCase())
  );
  if (filtered.length === 0) {
    productList.innerHTML = `<div class="col-12 text-center text-muted py-5">
      <span class="material-symbols-rounded" style="font-size:3rem;opacity:.4;">search_off</span><br>
      Tidak ada produk ditemukan.
    </div>`;
    return;
  }
  filtered.forEach(product => {
    const card = `
      <div class="col mb-3">
        <div class="card h-100 shadow-sm" style="min-width:120px; max-width:170px; border-radius:12px;">
          <img class="card-img-top" src="https://dummyimage.com/180x120/dee2e6/6c757d.jpg" alt="${product.name}" style="height:90px;object-fit:cover;border-top-left-radius:12px;border-top-right-radius:12px;">
          <div class="card-body p-2">
            <div class="text-center">
              <h6 class="fw-bold mb-1" style="font-size:1rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${product.name}</h6>
              <div style="font-size:.95rem;">Rp. ${Number(product.price).toLocaleString('id-ID')}</div>
              <small class="text-muted">Stok: <span id="stok-${product.id}">${product.stock}</span></small>
            </div>
          </div>
          <div class="card-footer p-2 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
              <button 
                class="btn btn-outline-dark btn-sm mt-auto addToCartBtn rounded-pill px-2 py-1" 
                data-product-id="${product.id}"
                style="font-size:.95rem;"
                ${product.stock <= 0 ? 'disabled' : ''}
              >
                <span class="material-symbols-rounded align-middle" style="font-size:1.1rem;">add_shopping_cart</span>
                Tambah
              </button>
            </div>
          </div>
        </div>
      </div>
    `;
    productList.insertAdjacentHTML('beforeend', card);
  });
  document.querySelectorAll('.addToCartBtn').forEach(btn => {
    btn.addEventListener('click', () => addToCart(btn.dataset.productId));
  });
}

// Tambah ke keranjang
function addToCart(productId) {
  const product = products.find(p => p.id === productId);
  if (!product || product.stock <= 0) {
    alert("Stok habis!");
    return;
  }
  const existingItem = cart.find(item => item.id === productId);
  if (existingItem) {
    if (existingItem.quantity < product.stock) {
      existingItem.quantity++;
    } else {
      alert("Jumlah melebihi stok!");
      return;
    }
  } else {
    cart.push({ ...product, quantity: 1 });
  }
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
}

// Update jumlah keranjang
function updateCartCount() {
  document.getElementById('cart-count').textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
}

// Ubah jumlah item di keranjang
function changeCartQty(productId, delta) {
  const item = cart.find(i => i.id === productId);
  const product = products.find(p => p.id === productId);
  if (!item || !product) return;
  if (delta === 1 && item.quantity < product.stock) {
    item.quantity++;
  } else if (delta === -1 && item.quantity > 1) {
    item.quantity--;
  }
  localStorage.setItem('cart', JSON.stringify(cart));
  buildCartModal();
  updateCartCount();
}

// Hapus item dari keranjang
function removeCartItem(productId) {
  if (confirm('Hapus barang ini dari keranjang?')) {
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    buildCartModal();
    updateCartCount();
  }
}

// Tampilkan isi keranjang di modal
function buildCartModal() {
  const cartItemsDiv = document.getElementById('cartItems');
  cartItemsDiv.innerHTML = '';
  let totalPrice = 0;
  let totalItems = 0;
  if (cart.length === 0) {
    cartItemsDiv.innerHTML = '<div class="text-center text-muted">Keranjang kosong.</div>';
  }
  cart.forEach(item => {
    const product = products.find(p => p.id === item.id);
    const html = `
      <div class="d-flex align-items-center mb-3 border-bottom pb-3">
        <img src="https://dummyimage.com/80x80/dee2e6/6c757d.jpg" class="me-3 rounded" alt="${item.name}" style="width:80px;height:80px;object-fit:cover;">
        <div class="flex-grow-1">
          <div class="fw-bold">${item.name}</div>
          <div class="text-muted small">ID: ${item.id}</div>
          <div class="d-flex align-items-center mt-2">
            <button class="btn btn-sm btn-outline-secondary me-2" onclick="changeCartQty('${item.id}', -1)" ${item.quantity <= 1 ? 'disabled' : ''}>−</button>
            <span class="mx-1">${item.quantity}</span>
            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="changeCartQty('${item.id}', 1)" ${item.quantity >= (product ? product.stock : 0) ? 'disabled' : ''}>+</button>
            <button class="btn btn-sm btn-danger ms-3" onclick="removeCartItem('${item.id}')" title="Hapus dari keranjang">
              <i class="fas fa-trash"></i> Hapus
            </button>
          </div>
        </div>
        <div class="ms-auto text-end">
          <div class="fw-bold">Rp. ${(item.price * item.quantity).toLocaleString('id-ID')}</div>
          <div class="text-muted small">@Rp. ${Number(item.price).toLocaleString('id-ID')}</div>
        </div>
      </div>
    `;
    cartItemsDiv.insertAdjacentHTML('beforeend', html);
    totalPrice += item.price * item.quantity;
    totalItems += item.quantity;
  });
  document.getElementById('totalItems').textContent = totalItems;
  document.getElementById('totalPrice').textContent = `Rp. ${totalPrice.toLocaleString('id-ID')}`;
}

// Checkout
let showSuccessAlert = false;

function confirmCheckout() {
  if (cart.length === 0) {
    alert("Keranjang kosong!");
    return;
  }
  cart.forEach(item => {
    const product = products.find(p => p.id === item.id);
    if (product) {
      product.stock -= item.quantity;
      if (product.stock < 0) product.stock = 0;
    }
  });
  fetch('update_stok.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(products)
  }).then(res => res.json()).then(data => {
    if (data.success) {
      let kasir = sessionStorage.getItem('nama') || localStorage.getItem('username') || 'admin';
      let metode = 'Tunai';
      fetch('riwayat_transaksi.json?' + Date.now())
        .then(res => res.json())
        .then(riwayat => {
          let lastId = riwayat && riwayat.length > 0 ? riwayat[riwayat.length-1].id : null;
          let newId = lastId && lastId.startsWith('TRX-') ? 'TRX-' + String(parseInt(lastId.split('-')[1]) + 1).padStart(3, '0') : 'TRX-001';
          const transaksiBaru = {
            id: newId,
            jumlah: cart.reduce((sum, item) => sum + item.quantity, 0),
            tanggal: new Date().toISOString().slice(0,10),
            total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
            kasir: kasir,
            metode: metode,
            barang: cart.map(item => ({
              id: item.id,
              nama: item.name,
              qty: item.quantity,
              harga: item.price
            }))
          };
          fetch('simpan_transaksi.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(transaksiBaru)
          }).then(res => res.json()).then(result => {
            if (result.success) {
              cart = [];
              localStorage.removeItem('cart');
              buildCartModal();
              updateCartCount();
              // Fetch ulang produk agar stok benar-benar update
              fetch('inventaris.json?' + Date.now())
                .then(res => res.json())
                .then(freshProducts => {
                  if (Array.isArray(freshProducts)) {
                    for (let i = 0; i < products.length; i++) {
                      products[i].stock = freshProducts.find(p => p.id === products[i].id)?.stock ?? products[i].stock;
                    }
                  }
                  buildProductList();
                });
              // Set flag untuk alert sukses
              showSuccessAlert = true;
              // Tutup modal
              if (window.bootstrap && bootstrap.Modal) {
                const modalEl = document.getElementById('checkoutModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
              }
            } else {
              alert("Gagal simpan transaksi! " + (result.error || ''));
            }
          });
        });
    } else {
      alert("Gagal update stok!");
    }
  });
}

// Tambahkan event listener hanya sekali
document.addEventListener('DOMContentLoaded', () => {
  buildProductList();
  updateCartCount();
  const modalEl = document.getElementById('checkoutModal');
  if (modalEl) {
    modalEl.addEventListener('show.bs.modal', function () {
      buildCartModal();
    });
    modalEl.addEventListener('hidden.bs.modal', function () {
      if (showSuccessAlert) {
        alert("Transaksi berhasil! Stok & transaksi telah diperbarui.");
        showSuccessAlert = false;
      }
    });
  }
  // Fitur pencarian
  document.getElementById('searchProduct').addEventListener('input', function() {
    searchQuery = this.value;
    buildProductList();
  });
});

function resetCart() {
  if (confirm('Kosongkan seluruh keranjang?')) {
    cart = [];
    localStorage.removeItem('cart');
    buildCartModal();
    updateCartCount();
  }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
  </main>
</body>
</html>