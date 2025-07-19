<?php
// Komponen Sidebar dan Navbar Atas untuk Sima Shop
// Berisi navigasi utama, jam digital, dan tombol logout
?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 border-radius-xl shadow-none" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-3">
    <!-- Breadcrumb dan Jam Digital -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
      </ol>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <ul class="navbar-nav ms-auto align-items-center">
        <!-- Jam Digital -->
        <li class="nav-item d-flex align-items-center me-3">
          <span id="navbarClock" class="fw-bold" style="font-family:monospace;font-size:1.1rem;">00:00:00</span>
        </li>
        <!-- Logout -->
        <li class="nav-item d-flex align-items-center">
          <a href="../index.php" class="nav-link font-weight-bold px-0 text-body" title="Logout">
            <img src="../images/logout.png" alt="Logout" style="width:28px;height:28px;object-fit:contain;vertical-align:middle;">
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2 shadow" id="sidenav-main" style="min-height:100vh;">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-5 py-3 m-0" href="../pages/dashboard.php">
      <img src="../images/simashopdark.png" class="navbar-brand-img" width="26" height="26" alt="Logo">
      <span class="ms-1 text-sm text-dark">Sima Shop</span>
    </a>
  </div>

  <hr class="horizontal light mt-0 mb-2">

  <!-- Menu Navigasi Sidebar -->
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-dark d-flex align-items-center sidebar-link" href="../pages/dashboard.php">
          <span class="material-symbols-rounded me-2" style="font-size:1.5rem;">home</span>
          <span class="nav-link-text ms-1">Home</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark d-flex align-items-center sidebar-link" href="../pages/inventaris.php">
          <span class="material-symbols-rounded me-2" style="font-size:1.5rem;">inventory_2</span>
          <span class="nav-link-text ms-1">Inventaris</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark d-flex align-items-center sidebar-link" href="../pages/riwayat-transaksi.php">
          <span class="material-symbols-rounded me-2" style="font-size:1.5rem;">receipt_long</span>
          <span class="nav-link-text ms-1">Riwayat Transaksi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark d-flex align-items-center sidebar-link" href="../pages/pengguna.php">
          <span class="material-symbols-rounded me-2" style="font-size:1.5rem;">group</span>
          <span class="nav-link-text ms-1">Pengguna</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark d-flex align-items-center sidebar-link" href="../pages/kasir.php">
          <span class="material-symbols-rounded me-2" style="font-size:1.5rem;">point_of_sale</span>
          <span class="nav-link-text ms-1">Kasir</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark d-flex align-items-center sidebar-link" href="../pages/laporan.php">
          <span class="material-symbols-rounded me-2" style="font-size:1.5rem;">bar_chart</span>
          <span class="nav-link-text ms-1">Laporan Keuangan</span>
        </a>
      </li>
    </ul>
  </div>
</aside>

<style>
/* Efek hover dan aktif sidebar */
.sidebar-link {
  transition: background 0.2s, color 0.2s;
  border-radius: 0.5rem;
}
.sidebar-link:hover, .sidebar-link:focus {
  background: #222 !important;
  color: #fff !important;
}
.sidebar-link:hover .material-symbols-rounded,
.sidebar-link:focus .material-symbols-rounded,
.sidebar-link:hover .nav-link-text,
.sidebar-link:focus .nav-link-text {
  color: #fff !important;
}
.sidebar-link.active, .sidebar-link[aria-current="page"] {
  background: #111 !important;
  color: #fff !important;
}
.sidebar-link.active .material-symbols-rounded,
.sidebar-link.active .nav-link-text,
.sidebar-link[aria-current="page"] .material-symbols-rounded,
.sidebar-link[aria-current="page"] .nav-link-text {
  color: #fff !important;
}
</style>

<script>
// Jam Digital di Navbar Atas
function updateClock() {
  const now = new Date();
  const pad = n => n.toString().padStart(2, '0');
  const timeStr = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
  const el = document.getElementById('navbarClock');
  if (el) el.textContent = timeStr;
}
setInterval(updateClock, 1000);
updateClock();

// Highlight menu aktif otomatis berdasarkan URL
document.addEventListener('DOMContentLoaded', function() {
  const path = window.location.pathname.split('/').pop();
  document.querySelectorAll('.sidebar-link').forEach(link => {
    if (link.getAttribute('href') && link.getAttribute('href').includes(path)) {
      link.classList.add('active');
    }
  });
});
</script>

