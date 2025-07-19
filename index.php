<?php
// Halaman Login Sima.Shop
// Menyediakan form login dan autentikasi user berbasis localStorage
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS utama untuk tampilan login -->
    <link rel="stylesheet" href="assets/css/login-style.css">
</head>
<body>
    <!-- Kartu utama login -->
    <div class="card">
        <div class="hero">
            <div class="hero-inner">
                <h2>Sima.Shop</h2>
                <h3>Warung yang memenuhi kebutuhan anda sehari-hari.</h3>
            </div>
        </div>
        <!-- Form login -->
        <form id="loginForm">
            <h2>Selamat Datang</h2>
            <h3>Masuk ke Akun Anda</h3>
            <input type="text" id="loginId" class="form-control" placeholder="ID Pengguna" required>
            <input type="password" id="loginPassword" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
        // Proses login saat form disubmit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Ambil input user
            const userId = document.getElementById('loginId').value.trim();
            const password = document.getElementById('loginPassword').value.trim();

            // Ambil data pengguna dari localStorage
            const users = JSON.parse(localStorage.getItem('users')) || [];

            // Cari user yang cocok
            const foundUser = users.find(user => 
                user.id === parseInt(userId) && 
                user.password === password
            );

            if (foundUser) {
                // Simpan nama ke sessionStorage
                const username = userId;
                sessionStorage.setItem('nama', username);

                // Update waktu terakhir online user
                let userIndex = users.findIndex(u => u.username === username);
                if (userIndex !== -1) {
                    users[userIndex].lastOnline = new Date().toISOString();
                    localStorage.setItem('users', JSON.stringify(users));
                }

                // Redirect ke halaman kasir
                window.location.href = 'pages/dashboard.php';
            } else {
                alert("ID atau password salah!");
            }
        });
    </script>
</body>
</html>