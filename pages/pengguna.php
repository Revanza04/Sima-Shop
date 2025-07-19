<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sima Shop - Pengguna</title>
  <!--
    Halaman Pengguna Sima Shop
    Menampilkan daftar pengguna, fitur tambah, edit, hapus, dan upload foto profil.
    Data pengguna disimpan di localStorage browser.
  -->
  <!-- CSS Material Dashboard -->
  <link href="../assets/css/material-dashboard.css" rel="stylesheet">
  <link id="pagestyle" href="../assets/css/material-dashboard.css" rel="stylesheet" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <!-- Core -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <!-- Theme JS -->
  <script src="../assets/js/material-dashboard.min.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
  <script src="../assets/js/material-dashboard.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <link href="../assets/css/custom.css" rel="stylesheet">

  <style>
    /* Styling untuk preview foto profil di modal pengguna */
    #previewPhoto {
      max-width: 120px;
      border-radius: 50%;
      box-shadow: 0 2px 8px rgba(0,0,0,0.07);
      margin-bottom: 0.5rem;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    #userModal .photo-upload {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 1rem;
    }
    #userModal #previewPhoto {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 2px 8px rgba(0,0,0,0.07);
      background: #f4f4f4;
      margin-bottom: 0.5rem;
    }
    #userModal .btn-upload-photo {
      font-size: 0.95rem;
      padding: 2px 14px;
      border-radius: 20px;
      margin-bottom: 0.5rem;
    }
    /* Modal Pengguna Styling */
    #userModal .modal-content {
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(60,60,60,0.13);
      border: none;
    }
    #userModal .modal-header {
      border-bottom: 1px solid #eee;
      padding-bottom: 0.5rem;
    }
    #userModal .modal-title {
      font-size: 1.2rem;
      font-weight: 700;
    }
    #userModal .modal-body {
      background: #fafbfc;
      padding-bottom: 0;
    }
    #userModal .form-control {
      border-radius: 8px;
      font-size: 1rem;
    }
    #userModal .form-control::placeholder {
      color: #bbb;
      font-size: 1rem;
    }
    #userModal .modal-footer {
      border-top: none;
      padding-top: 0;
      padding-bottom: 1.2rem;
      gap: 8px;
    }
    #userModal .btn-primary,
    #userModal .btn-danger,
    #userModal .btn-secondary {
      border-radius: 8px;
    }
  </style>

</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../components/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg"
        style="margin-left: 270px; transition: margin-left .3s;">
    <!-- Tombol Tambah Pengguna -->
    <button class="btn btn-outline-dark m-3" type="button" data-bs-toggle="modal" data-bs-target="#userModal">
      <i class="bi-person-plus me-1"></i>
      Tambah Pengguna
    </button>

    <!-- Tabel Pengguna -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Daftar Pengguna</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Foto</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Posisi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu Bergabung</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody id="userTableBody">
                    <!-- Data pengguna akan dimuat di sini -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Tambah/Edit Pengguna -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header pb-2">
            <h5 class="modal-title" id="userModalLabel">Tambah Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body pt-2">
            <form id="userForm" autocomplete="off">
              <!-- Foto Profil -->
              <div class="photo-upload">
                <img id="previewPhoto" src="../assets/img/team-2.jpg" alt="Foto">
                <label for="photoInput" class="btn btn-sm btn-outline-primary btn-upload-photo">
                  <i class="fas fa-camera me-1"></i> Pilih Foto
                </label>
                <input type="file" class="d-none" id="photoInput" accept="image/*">
              </div>
              <!-- Nama Pengguna -->
              <div class="mb-2">
                <input type="text" class="form-control" id="nameInput" placeholder="Nama" required>
              </div>
              <!-- Posisi Pengguna -->
              <div class="mb-2">
                <input type="text" class="form-control" id="positionInput" placeholder="Posisi" required>
              </div>
              <!-- Password -->
              <div class="mb-2" id="passwordContainer">
                <input type="password" class="form-control" id="passwordInput" placeholder="Password" required>
              </div>
              <!-- Konfirmasi Password -->
              <div class="mb-2" id="confirmPasswordContainer">
                <input type="password" class="form-control" id="confirmPasswordInput" placeholder="Ulangi Password" required>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger" onclick="deleteUser()">Hapus</button>
            <button type="button" class="btn btn-primary" onclick="saveUser()">Simpan</button>
          </div>
        </div>
      </div>
    </div>

<script>
let users = [];
let currentUserId = null;

// Load data dari localStorage
document.addEventListener('DOMContentLoaded', function() {
  const storedUsers = localStorage.getItem('users');
  if (storedUsers) {
    users = JSON.parse(storedUsers);
  }
  buildTable();
});

// Fungsi membangun tabel
function buildTable() {
  const tbody = document.getElementById('userTableBody');
  tbody.innerHTML = '';
  users.forEach(user => {
    const row = `
      <tr>
        <td>
          <div class="d-flex px-2 py-1">
            <img src="${user.photo}" class="avatar avatar-sm me-3 border-radius-lg" alt="${user.name}">
          </div>
        </td>
        <td>
          <h6 class="mb-0 text-sm">${user.name}</h6>
          <p class="text-xs text-secondary mb-0">${user.id}</p>
        </td>
        <td>
          <p class="text-xs font-weight-bold mb-0">${user.position.split(' - ')[0]}</p>
          ${user.position.split(' - ')[1] ? `<p class="text-xs text-secondary mb-0">${user.position.split(' - ')[1]}</p>` : ''}
        </td>
        <td class="align-middle text-center">
          <span class="text-secondary text-xs font-weight-bold">${user.joinTime}</span>
        </td>
        <td class="align-middle">
          <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="editUser(${user.id})">
            Edit
          </a>
        </td>
      </tr>
    `;
    tbody.insertAdjacentHTML('beforeend', row);
  });
}

// Fungsi untuk menampilkan modal tambah
function showAddUserModal() {
  document.getElementById('userModalLabel').textContent = 'Tambah Pengguna';
  document.getElementById('userForm').reset();
  document.getElementById('previewPhoto').src = '../assets/img/team-2.jpg';
  document.getElementById('previewPhoto').style.display = 'block';
  currentUserId = null;
  // Tampilkan password fields saat tambah pengguna
  document.getElementById('passwordContainer').classList.remove('d-none');
  document.getElementById('confirmPasswordContainer').classList.remove('d-none');
  document.querySelector('#userModal .btn-danger').style.display = 'none';
}

// Fungsi untuk menyimpan pengguna
function saveUser() {
  const name = document.getElementById('nameInput').value.trim();
  const position = document.getElementById('positionInput').value.trim();
  const passwordInput = document.getElementById('passwordInput');
  const confirmPasswordInput = document.getElementById('confirmPasswordInput');
  const photoInput = document.getElementById('photoInput');

  // Validasi
  if (!name || !position) {
    alert("Nama dan posisi harus diisi!");
    return;
  }

  // Validasi password
  if (currentUserId === null) { // Tambah pengguna baru
    const password = passwordInput.value.trim();
    const confirmPassword = confirmPasswordInput.value.trim();
    if (!password || !confirmPassword || password !== confirmPassword) {
      alert("Password harus diisi dan harus sama!");
      return;
    }
  }

  // Ambil foto
  let photo = '../assets/img/team-2.jpg'; // Default photo
  if (photoInput.files[0]) {
    photo = URL.createObjectURL(photoInput.files[0]);
  } else if (currentUserId !== null) {
    const user = users.find(u => u.id === currentUserId);
    photo = user?.photo || photo;
  }

  if (currentUserId === null) {
    // Tambah pengguna baru
    const newId = users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 25001;
    const nowISO = new Date().toISOString();
    const newUser = {
      id: newId,
      name: name,
      position: position,
      password: passwordInput.value,
      status: 'online',
      joinTime: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: '2-digit' }),
      lastOnline: nowISO, // <-- Tambahkan ini
      photo: photo
    };
    users.push(newUser);
  } else {
    // Update pengguna
    const index = users.findIndex(u => u.id === currentUserId);
    users[index].name = name;
    users[index].position = position;
    users[index].photo = photo;
    // Update password hanya jika diisi
    if (passwordInput.value) {
      users[index].password = passwordInput.value;
    }
  }

  // Simpan ke localStorage
  localStorage.setItem('users', JSON.stringify(users));
  buildTable();
  const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
  modal.hide();
}

// Fungsi untuk edit pengguna
function editUser(id) {
  const user = users.find(u => u.id === id);
  currentUserId = id;

  // Isi form dengan data pengguna
  document.getElementById('userModalLabel').textContent = 'Edit Pengguna';
  document.getElementById('nameInput').value = user.name;
  document.getElementById('positionInput').value = user.position;

  // Sembunyikan password fields saat edit
  document.getElementById('passwordContainer').classList.add('d-none');
  document.getElementById('confirmPasswordContainer').classList.add('d-none');

  // Tampilkan preview foto
  const preview = document.getElementById('previewPhoto');
  preview.src = user.photo;
  preview.style.display = 'block';

  // Tampilkan tombol hapus
  document.querySelector('#userModal .btn-danger').style.display = 'inline-block';

  // Buka modal
  const modal = new bootstrap.Modal(document.getElementById('userModal'));
  modal.show();
}

// Fungsi untuk menghapus pengguna
function deleteUser() {
  if (currentUserId === null) return;
  const confirmDelete = confirm("Apakah Anda yakin ingin menghapus pengguna ini?");
  if (!confirmDelete) return;
  users = users.filter(user => user.id !== currentUserId);
  localStorage.setItem('users', JSON.stringify(users));
  buildTable();
  const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
  modal.hide();
}

// Event listener untuk preview foto
document.getElementById('photoInput').addEventListener('change', function(e) {
  if (e.target.files[0]) {
    const reader = new FileReader();
    reader.onload = function(event) {
      document.getElementById('previewPhoto').src = event.target.result;
      document.getElementById('previewPhoto').style.display = 'block';
    };
    reader.readAsDataURL(e.target.files[0]);
  }
});

// Event listener untuk modal ditutup
document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
  document.getElementById('previewPhoto').style.display = 'block';
  document.getElementById('userForm').reset();
  currentUserId = null;
  // Sembunyikan password fields
  document.getElementById('passwordContainer').classList.add('d-none');
  document.getElementById('confirmPasswordContainer').classList.add('d-none');
  // Sembunyikan tombol hapus
  document.querySelector('#userModal .btn-danger').style.display = 'none';
});

// Event listener untuk tombol "Tambah Pengguna"
document.querySelector('[data-bs-target="#userModal"]').addEventListener('click', showAddUserModal);
</script>
<!-- Bootstrap & Material Dashboard JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/material-dashboard.min.js"></script>
    </main>
</body>
</html>