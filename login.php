<?php
session_start();
include 'koneksi.php';

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

    $result = mysqli_query($conn, "SELECT * FROM guru WHERE nama_guru = '$nama_guru'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_guru'] = $row['id']; 
            $_SESSION['nama'] = $row['nama_guru'];
            $_SESSION['level'] = $row['level'];

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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Sekolah</title>
    <link rel="icon" type="image/jpeg" href="img/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 md:p-6 relative overflow-x-hidden">

    <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50"></div>

    <a href="index.php" class="absolute top-6 left-6 md:top-10 md:left-10 flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-all font-bold group z-50 text-sm md:text-base">
        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
        <span>Kembali ke Beranda</span>
    </a>

    <div class="max-w-md w-full bg-white/80 backdrop-blur-xl p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-white relative z-10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-3xl shadow-xl border border-slate-50 mb-6 overflow-hidden">
                <img src="img/logo.jpeg" alt="Logo Sekolah" class="w-full h-full object-cover p-1">
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight italic uppercase">Login System</h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base italic">                <span class="font-black text-base tracking-tight text-slate-800">MY<span class="text-blue-600">TEACHER </span></span> Digital Management</p>
        </div>

        <?php if (isset($error)) : ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl text-xs md:text-sm font-bold mb-6 flex items-center gap-3 animate-pulse">
                <i class="fas fa-exclamation-circle text-lg"></i>
                Identitas tidak valid, periksa kembali!
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-5">
            <div>
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-2 ml-1 uppercase italic tracking-wider">Username</label>
                <div class="relative group">
                    <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                    <input type="text" name="nama_guru" required placeholder="Masukkan nama"
                           class="w-full pl-14 pr-5 py-3.5 md:py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 focus:outline-none transition-all text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-2 ml-1 uppercase italic tracking-wider">Password</label>
                <div class="relative group">
                    <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                    <input type="password" name="password" required placeholder="********"
                           class="w-full pl-14 pr-5 py-3.5 md:py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 focus:outline-none transition-all text-sm">
                </div>
            </div>

            <button type="submit" name="login"
                    class="w-full bg-indigo-600 text-white font-bold py-4 md:py-5 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 active:scale-[0.98] transition-all duration-300 uppercase tracking-widest text-sm italic mt-2">
                Masuk Sekarang <i class="fas fa-right-to-bracket ml-2"></i>
            </button>
        </form>

        <div class="mt-8 pt-8 border-t border-slate-100 flex flex-col gap-4">
            <p class="text-center text-slate-400 text-[10px] md:text-xs font-medium leading-relaxed">
                Butuh bantuan? Silakan hubungi <a href="mailto:anosvldg17@gmail.com?subject=Permintaan Bantuan Login&body=Halo Admin, saya ingin meminta bantuan untuk login ke sistem. Berikut detail identitas saya:" class="text-indigo-600 hover:underline">admin</a> <br>
            </p>
        </div>
    </div>

</body>
</html>