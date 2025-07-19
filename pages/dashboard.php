<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sima Shop - Dashboard</title>
  <!-- CSS Material Dashboard -->
  <link href="../assets/css/material-dashboard.css" rel="stylesheet">
  <link href="../assets/css/custom.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../components/sidebar.php'; ?>
  <!-- Konten Utama -->
  <main>
    <div class="main-content">
      <div class="container-fluid py-3">

        <div class="row justify-content-center">
          <div class="ms-3">
            <h3 class="mb-0 h4 font-weight-bolder">Selamat Datang Di Sima Shop</h3>
            <p class="mb-4">
              Warung yang memenuhi kebutuhan anda sehari-hari.
            </p>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                  <div>
                    <p class="text-sm mb-0 text-capitalize">Pemasukan Harian</p>
                    <h4 class="mb-0">-</h4>
                  </div>
                  <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <span class="material-symbols-rounded" style="font-size:2rem;">attach_money</span>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm"><span class="font-weight-bolder"></span></p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                  <div>
                    <p class="text-sm mb-0 text-capitalize">Jumlah Transaksi</p>
                    <h4 class="mb-0">-</h4>
                  </div>
                  <div class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <span class="material-symbols-rounded" style="font-size:2rem;">receipt_long</span>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm"><span class="font-weight-bolder"></span></p>
              </div>
            </div>
          </div>
          <!-- Stok Menipis Widget -->
          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="flex-grow-1" style="min-width:0;">
                    <p class="text-sm mb-0 text-capitalize">Stok Menipis</p>
                    <div style="height:28px;overflow:hidden;position:relative;display:flex;align-items:center;min-width:0;">
                      <marquee behavior="scroll" direction="left" scrollamount="4"
                        style="white-space:nowrap;font-size:1rem;font-weight:600;opacity:0.95;color:#d32f2f;width:100%;min-width:0;" id="marqueeStokMenipis">
                        <!-- Akan diisi JS -->
                      </marquee>
                    </div>
                  </div>
                  <div class="icon icon-md icon-shape bg-gradient-danger shadow-danger shadow text-center border-radius-lg d-flex align-items-center justify-content-center ms-2"
                    style="width:48px;height:48px;">
                    <span class="material-symbols-rounded" style="font-size:2rem;">inventory_2</span>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm"><span class="font-weight-bolder" id="stokMenipisJumlah">-</span> <span id="stokMenipisStatus">Darurat !</span></p>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <!-- Kolom Pertama: Pemasukan -->
          <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card h-100" style="min-height: 340px;"> <!-- Tambahkan h-100 dan min-height -->
              <div class="card-body d-flex flex-column" style="height:100%;">
                <h6 class="mb-0">Pemasukan</h6>
                <p class="text-sm">(<span class="text-success font-weight-bolder"></span>) Total penjualan selama beberapa saat.</p>
                <div class="pe-2 flex-grow-1 d-flex align-items-center" style="min-height:120px;">
                  <div class="chart w-100">
                    <canvas id="chart-line" class="chart-canvas"></canvas>
                  </div>
                </div>
                <hr class="dark horizontal">
                <div class="d-flex mt-auto">
                  <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                  <p class="mb-0 text-sm"></p>
                </div>
              </div>
            </div>
          </div>

          <!-- Kolom Kedua: Stok & Pengguna -->
          <div class="col-lg-8 col-md-6">
            <div class="row">
              <!-- Sub-Kolom Stok -->
              <div class="col-lg-6 mt-4 mb-3">
                <div class="card">
                  <div class="card-body">
                    <h6 class="mb-0">Stok</h6>
                    <p class="text-sm">Berdasarkan jumlah paling sedikit</p>
                    <div class="pe-2">
                      <div class="chart">
                        <canvas id="chart-line-tasks" class="chart-canvas"></canvas>
                      </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                      <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                      <p class="mb-0 text-sm"></p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Sub-Kolom Pengguna -->
              <div class="col-lg-4 col-md-6 mt-4 mb-3">
                <div class="card h-100" style="min-height:auto; max-width:350px; margin:auto;">
                  <div class="card-header pb-0">
                    <h6>Pengguna</h6>
                    <p class="text-sm"><span class="font-weight-bold">Terakhir Online</span></p>
                  </div>
                  <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                      <!-- Akan diisi oleh JS -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
</body>
</html>
<script>
// --- Helper: Format Rupiah ---
function formatRupiah(angka) {
  return 'Rp. ' + Number(angka).toLocaleString('id-ID');
}

// Helper: Hitung selisih persen
function hitungPersen(now, prev) {
  if (prev === 0) return now > 0 ? 100 : 0;
  return Math.round(((now - prev) / prev) * 100);
}

// Helper: Format waktu update (realtime)
function waktuUpdate(ts) {
  const now = new Date();
  const tgl = new Date(ts);
  const diffMs = now - tgl;
  const diffMnt = Math.floor(diffMs / 60000);
  const diffJam = Math.floor(diffMnt / 60);
  const diffHari = Math.floor(diffMnt / 1440);
  if (diffMnt < 1) return 'Baru saja';
  if (diffMnt < 60) return diffMnt + ' menit yang lalu';
  if (diffJam < 24) return diffJam + ' jam yang lalu';
  return diffHari + ' hari yang lalu';
}

// --- 1. Widget Pemasukan Harian & Grafik Pemasukan (Y axis dinamis ribuan rupiah) ---
let lastTrxUpdate = null;
fetch('riwayat_transaksi.json?' + Date.now())
  .then(res => res.json())
  .then(trx => {
    if (!Array.isArray(trx)) trx = [];
    // Hari ini & kemarin
    const today = new Date();
    const todayStr = today.toISOString().slice(0,10);
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);
    const yesterdayStr = yesterday.toISOString().slice(0,10);

    let pemasukanHarian = 0, pemasukanKemarin = 0;
    let transaksiHarian = 0, transaksiKemarin = 0;
    trx.forEach(t => {
      if (t.tanggal === todayStr) {
        pemasukanHarian += t.total || 0;
        transaksiHarian++;
      }
      if (t.tanggal === yesterdayStr) {
        pemasukanKemarin += t.total || 0;
        transaksiKemarin++;
      }
    });

    // Update widget
    document.querySelectorAll('.card').forEach(card => {
      // Pemasukan Harian
      if (card.innerHTML.includes('Pemasukan Harian')) {
        card.querySelector('h4').textContent = formatRupiah(pemasukanHarian);
        let persen = hitungPersen(pemasukanHarian, pemasukanKemarin);
        let diff = pemasukanHarian - pemasukanKemarin;
        card.querySelector('.card-footer p').innerHTML = `<span class="${diff >= 0 ? 'text-success' : 'text-danger'} font-weight-bolder">${diff >= 0 ? '+' : ''}${persen}% </span>${diff >= 0 ? 'lebih banyak' : 'lebih sedikit'} dari kemarin`;
      }
      // Jumlah Transaksi
      if (card.innerHTML.includes('Jumlah Transaksi')) {
        card.querySelector('h4').textContent = transaksiHarian + ' Transaksi';
        let diff = transaksiHarian - transaksiKemarin;
        card.querySelector('.card-footer p').innerHTML = `<span class="${diff >= 0 ? 'text-success' : 'text-danger'} font-weight-bolder">${diff >= 0 ? '+' : ''}${diff} </span>${diff >= 0 ? 'Lebih banyak' : 'Lebih sedikit'} dari kemarin`;
      }
    });

    // Grafik Pemasukan 7 Hari Terakhir (Y axis dinamis)
    const pemasukanPerHari = {};
    for (let i = 6; i >= 0; i--) {
      const d = new Date();
      d.setDate(d.getDate() - i);
      const key = d.toISOString().slice(0,10);
      pemasukanPerHari[key] = 0;
    }
    trx.forEach(t => {
      if (t.tanggal in pemasukanPerHari) {
        pemasukanPerHari[t.tanggal] += t.total || 0;
      }
    });
    const labels = Object.keys(pemasukanPerHari);
    const data = Object.values(pemasukanPerHari);

    // Simpan waktu transaksi terakhir
    lastTrxUpdate = trx.length > 0 ? trx.map(t => t.tanggal).sort().reverse()[0] : null;

    // Tentukan max pemasukan untuk menentukan step grid
    let max = Math.max(...data, 100000);
    let steps = [10000, 25000, 50000, 75000, 100000, 200000, 500000];
    let step = steps.find(s => max <= s) || 100000;
    if (max > 100000) step = Math.ceil(max / 5 / 10000) * 10000;

    if (window.Chart) {
      const ctx = document.getElementById('chart-line').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Pemasukan',
            data: data,
            borderColor: '#4caf50',
            backgroundColor: 'rgba(76,175,80,0.1)',
            fill: true,
            tension: 0.3
          }]
        },
        options: {
          plugins: { 
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return 'Rp. ' + context.parsed.y.toLocaleString('id-ID');
                }
              }
            }
          },
          scales: { 
            y: { 
              beginAtZero: true,
              suggestedMax: step,
              ticks: {
                stepSize: step / 5,
                callback: function(value) {
                  if (value >= 1000) return (value/1000) + 'rb';
                  return value;
                }
              }
            }
          }
        }
      });
    }
    updateWaktuWidget();
  });

// --- 3. Widget Stok Menipis & Grafik Stok (batang vertikal hijau & rapi) ---
let lastStokUpdate = null;
fetch('inventaris.json?' + Date.now())
  .then(res => res.json())
  .then(products => {
    if (!Array.isArray(products)) products = [];
    // Ambil semua barang dengan stok <= 4
    let barangMenipis = products.filter(p => p.stock !== undefined && p.stock <= 4);
    if (barangMenipis.length > 0) {
      let minStock = Math.min(...barangMenipis.map(p => p.stock));
      let namaBarangMenipis = barangMenipis.map(p => p.name || '(Tanpa Nama)').join(' | ');
      document.getElementById('marqueeStokMenipis').textContent = namaBarangMenipis;
      document.getElementById('stokMenipisJumlah').textContent = minStock;
      document.getElementById('stokMenipisJumlah').className = 'text-danger font-weight-bolder';
      document.getElementById('stokMenipisStatus').textContent = 'Darurat!';
      document.getElementById('stokMenipisStatus').className = 'text-danger font-weight-bolder';
    } else {
      // Semua stok aman
      document.getElementById('marqueeStokMenipis').textContent = '-';
      document.getElementById('stokMenipisJumlah').textContent = '-';
      document.getElementById('stokMenipisJumlah').className = 'text-success font-weight-bolder';
      document.getElementById('stokMenipisStatus').textContent = 'semuanya masih terpenuhi';
      document.getElementById('stokMenipisStatus').className = 'text-success font-weight-bolder';
    }

    // Grafik stok 5 barang terendah (batang vertikal warna berbeda, label running text warna sesuai batang)
    const sorted = [...products].sort((a,b) => a.stock-b.stock).slice(0,5);
    // Warna batang dan teks (bisa diubah sesuai selera)
    const barColors = ['#4caf50', '#2196f3', '#ff9800', '#e91e63', '#9c27b0'];
    if (window.Chart) {
      const ctx = document.getElementById('chart-line-tasks').getContext('2d');
      // Buat elemen label running text di bawah grafik
      let chartContainer = ctx.canvas.parentElement;
      let marqueeId = 'stokBarLabelMarquee';
      let marquee = document.getElementById(marqueeId);
      if (!marquee) {
        marquee = document.createElement('div');
        marquee.id = marqueeId;
        marquee.style = "width:100%;overflow:hidden;margin-top:8px;";
        chartContainer.parentElement.appendChild(marquee);
      }
      // Isi label dengan nama barang (running text) dan warna sesuai batang
      let labelText = sorted.map((p, i) => {
        const color = barColors[i % barColors.length];
        return `<span style="color:${color};font-weight:600;">${p.name || '(Tanpa Nama)'}</span>`;
      }).join('   |   ');
      marquee.innerHTML = `<marquee behavior="scroll" direction="left" scrollamount="4" style="font-size:1rem;">${labelText}</marquee>`;

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: sorted.map((_, i) => (i+1)), // label angka saja agar batang di tengah
          datasets: [{
            label: 'Stok',
            data: sorted.map(p => p.stock),
            backgroundColor: barColors.slice(0, sorted.length)
          }]
        },
        options: {
          plugins: { 
            legend: { display: false },
            tooltip: {
              callbacks: {
                title: function(context) {
                  // Tampilkan nama lengkap di tooltip
                  return sorted[context[0].dataIndex].name || '(Tanpa Nama)';
                },
                labelTextColor: function(context) {
                  // Tooltip label warna sesuai batang
                  return barColors[context.dataIndex % barColors.length];
                }
              }
            }
          },
          indexAxis: 'x', // vertikal
          layout: {
            padding: {
              left: 0,
              right: 0
            }
          },
          scales: { 
            x: {
              grid: { display: false },
              ticks: {
                display: false // sembunyikan label x axis agar tidak mengganggu
              }
            },
            y: { beginAtZero: true, precision:0 }
          }
        }
      });
    }

    // Ambil waktu update stok terakhir (jika ada updated_at, jika tidak pakai waktu sekarang)
    lastStokUpdate = null;
    if (products.length > 0) {
      let updatedList = products.map(p => p.updated_at ? new Date(p.updated_at) : null).filter(Boolean);
      if (updatedList.length > 0) {
        lastStokUpdate = new Date(Math.max.apply(null, updatedList));
      } else {
        lastStokUpdate = new Date();
      }
    } else {
      lastStokUpdate = new Date();
    }
    updateWaktuWidget();
  });

// --- Update waktu widget secara realtime ---
function updateWaktuWidget() {
  // Widget pemasukan (bawah grafik pemasukan)
  document.querySelectorAll('.card').forEach(card => {
    if (card.innerHTML.includes('Pemasukan</h6>')) {
      let info = card.querySelector('.d-flex p');
      if (info) {
        if (lastTrxUpdate) {
          info.textContent = waktuUpdate(lastTrxUpdate);
        } else {
          info.textContent = 'Baru saja';
        }
      }
    }
    // Widget stok (bawah grafik stok)
    if (card.innerHTML.includes('Stok</h6>')) {
      let info = card.querySelector('.d-flex p');
      if (info) {
        if (lastStokUpdate) {
          info.textContent = waktuUpdate(lastStokUpdate);
        } else {
          info.textContent = 'Baru saja';
        }
      }
    }
  });
}

// Update waktu widget setiap menit agar selalu realtime
setInterval(updateWaktuWidget, 60000);

// --- 5. Widget Pengguna Terakhir Online (waktu sesungguhnya) ---
function tampilkanPenggunaTerakhir() {
  let users = [];
  try {
    users = JSON.parse(localStorage.getItem('users')) || [];
  } catch {}
  // Urutkan berdasarkan lastOnline terbaru (descending)
  users = users.sort((a, b) => new Date(b.lastOnline || 0) - new Date(a.lastOnline || 0));
  const timeline = document.querySelector('.timeline-one-side');
  if (timeline) {
    timeline.innerHTML = '';
    users.slice(0, 3).forEach(user => {
      let waktu = '-';
      if (user.lastOnline) {
        waktu = waktuUpdate(user.lastOnline);
      }
      timeline.innerHTML += `
        <div class="timeline-block mb-3">
          <span class="timeline-step">
            <i class="material-symbols-rounded text-success text-gradient">notifications</i>
          </span>
          <div class="timeline-content">
            <h6 class="text-dark text-sm font-weight-bold mb-0">${user.name}</h6>
            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">${waktu}</p>
          </div>
        </div>
      `;
    });
  }
}
tampilkanPenggunaTerakhir();
setInterval(tampilkanPenggunaTerakhir, 60000); // update setiap 1 menit
</script>
