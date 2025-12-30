<?php
session_start();
include 'koneksi.php';

// 1. LOGIKA ANTI-LOOP
// Jika sudah login, langsung arahkan ke dashboard yang sesuai agar tidak terjadi redirect berulang
if (isset($_SESSION['login'])) {
    if ($_SESSION['level'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: kelola/index.php");
    }
    exit;
}

if (isset($_POST['login'])) {
    $nama_guru = mysqli_real_escape_string($conn, $_POST['nama_guru']);
    $password = $_POST['password'];

    // Cari user berdasarkan nama
    $result = mysqli_query($conn, "SELECT * FROM guru WHERE nama_guru = '$nama_guru'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // 2. VERIFIKASI HASHING PASSWORD
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $row['id'];
            $_SESSION['nama'] = $row['nama_guru'];
            $_SESSION['level'] = $row['level'];

            // Redirect sesuai level
            if ($row['level'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: kelola/index.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-600 rounded-3xl shadow-lg shadow-indigo-200 mb-6">
                <i class="fas fa-school text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h1>
            <p class="text-slate-500 mt-2">Silakan login untuk mengakses sistem</p>
        </div>

        <?php if (isset($error)) : ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl text-sm font-bold mb-6 flex items-center gap-3">
                <i class="fas fa-exclamation-circle"></i>
                Username atau Password salah!
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Pengguna</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="nama_guru" required placeholder="Masukkan nama"
                           class="w-full pl-14 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 focus:outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password" required placeholder="********"
                           class="w-full pl-14 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 focus:outline-none transition-all">
                </div>
            </div>

            <button type="submit" name="login"
                    class="w-full bg-indigo-600 text-white font-bold py-5 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-[0.98] transition-all duration-300">
                MASUK KE SISTEM
            </button>
        </form>

        <p class="text-center text-slate-400 text-sm mt-8">
            Lupa password? Hubungi Admin IT Sekolah.
        </p>
    </div>

</body>
</html>