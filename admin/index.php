<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'admin') {
  header("Location: ../login.php");
exit;
}
include 'koneksi.php';

$id_admin = 1; 
$query_admin = mysqli_query($conn, "SELECT nama_guru, foto FROM guru WHERE id = '$id_admin'");
$data_admin = mysqli_fetch_assoc($query_admin);

$count_guru = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM guru"));
$count_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT id_siswa FROM daftar_siswa"));
$count_nilai = mysqli_num_rows(mysqli_query($conn, "SELECT id_siswa FROM daftar_nilai"));

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Raport</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex">

    <?php include 'sidebar.php'; ?>
    <main class="flex-1 min-h-screen p-8">
        
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Ringkasan Sistem</h1>
                <p class="text-slate-500">Selamat datang kembali, <?= $data_admin['nama_guru']; ?>!</p>
            </div>
            <div class="text-sm text-slate-400 font-medium">
                <i class="fa-regular fa-calendar-days mr-2"></i>
                <?= date('l, d F Y'); ?>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Guru</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= $count_guru; ?></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Siswa</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= $count_siswa; ?></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Input Nilai</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= $count_nilai; ?></h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Aksi Cepat</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="registrasi_guru.php" class="p-4 border border-dashed border-slate-200 rounded-2xl hover:bg-indigo-50 hover:border-indigo-200 transition-all group">
                        <i class="fas fa-user-plus text-indigo-500 mb-2 block"></i>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-700">Tambah Guru Baru</span>
                    </a>
                    <a href="#" class="p-4 border border-dashed border-slate-200 rounded-2xl hover:bg-emerald-50 hover:border-emerald-200 transition-all group">
                        <i class="fas fa-print text-emerald-500 mb-2 block"></i>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-emerald-700">Cetak Laporan</span>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-900 p-8 rounded-3xl shadow-xl shadow-indigo-900/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-xl font-bold mb-2">Pusat Bantuan</h2>
                    <p class="text-indigo-200 text-sm mb-6">Butuh bantuan dalam mengelola data guru atau pengaturan sistem?</p>
                    <button class="bg-white text-indigo-900 px-6 py-2 rounded-xl font-bold text-sm hover:bg-indigo-50 transition-colors">
                        Hubungi IT Support
                    </button>
                </div>
                <i class="fas fa-shield-halved absolute -bottom-10 -right-10 text-9xl text-indigo-800 opacity-50"></i>
            </div>
        </div>

    </main>
</body>
</html>