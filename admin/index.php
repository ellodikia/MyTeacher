<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include 'koneksi.php';

$id_session = $_SESSION['id_guru'] ?? 0;
$query_admin = mysqli_query($conn, "SELECT nama_guru, foto FROM guru WHERE id = '$id_session'");
$data_admin = mysqli_fetch_assoc($query_admin);

$count_guru = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM guru"))[0];
$count_siswa = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM daftar_siswa"))[0];
$count_nilai = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM daftar_nilai"))[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MYTEACHER</title>
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-responsive {
            font-size: clamp(0.75rem, 2vw, 1rem);
        }
    </style>
</head>
<body class="bg-slate-50 flex flex-col md:flex-row min-h-screen">
    
    <?php include 'sidebar.php'; ?>
    
    <main class="flex-1 p-3 md:p-8 w-full overflow-x-hidden">
        
        <header class="flex justify-between items-center gap-2 mb-6 md:mb-10">
            <div>
                <h1 class="text-base md:text-2xl font-bold text-slate-800 uppercase tracking-tight">Ringkasan</h1>
                <p class="text-[10px] md:text-sm text-slate-500 italic">Halo, <?= htmlspecialchars($data_admin['nama_guru'] ?? 'Admin'); ?>!</p>
            </div>
            <div class="text-[10px] md:text-sm text-slate-400 font-bold bg-white px-3 py-2 rounded-xl shadow-sm border border-slate-100 whitespace-nowrap">
                <i class="fa-regular fa-calendar-days mr-1 text-indigo-500"></i>
                <span class="hidden sm:inline"><?= date('l, '); ?></span><?= date('d/m/y'); ?>
            </div>
        </header>

        <div class="grid grid-cols-3 gap-2 md:gap-6 mb-6 md:mb-10">
            <div class="bg-white p-3 md:p-6 rounded-xl md:rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row items-center text-center md:text-left gap-2 md:gap-5">
                <div class="w-8 h-8 md:w-14 md:h-14 bg-indigo-50 text-indigo-600 rounded-lg md:rounded-xl flex items-center justify-center text-sm md:text-2xl">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <p class="text-[8px] md:text-sm font-bold text-slate-400 uppercase tracking-tighter">Guru</p>
                    <h3 class="text-sm md:text-2xl font-black text-slate-800"><?= $count_guru; ?></h3>
                </div>
            </div>
            <div class="bg-white p-3 md:p-6 rounded-xl md:rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row items-center text-center md:text-left gap-2 md:gap-5">
                <div class="w-8 h-8 md:w-14 md:h-14 bg-emerald-50 text-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center text-sm md:text-2xl">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <p class="text-[8px] md:text-sm font-bold text-slate-400 uppercase tracking-tighter">Siswa</p>
                    <h3 class="text-sm md:text-2xl font-black text-slate-800"><?= $count_siswa; ?></h3>
                </div>
            </div>
            <div class="bg-white p-3 md:p-6 rounded-xl md:rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row items-center text-center md:text-left gap-2 md:gap-5">
                <div class="w-8 h-8 md:w-14 md:h-14 bg-amber-50 text-amber-600 rounded-lg md:rounded-xl flex items-center justify-center text-sm md:text-2xl">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <p class="text-[8px] md:text-sm font-bold text-slate-400 uppercase tracking-tighter">Nilai</p>
                    <h3 class="text-sm md:text-2xl font-black text-slate-800"><?= $count_nilai; ?></h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 md:gap-8">
            <div class="bg-white p-4 md:p-8 rounded-2xl md:rounded-3xl shadow-sm border border-slate-100">
                <h2 class="text-xs md:text-lg font-bold text-slate-800 mb-3 md:mb-6 uppercase italic">Aksi</h2>
                <div class="flex flex-col gap-2 md:gap-4">
                    <a href="registrasi_guru.php" class="p-2 md:p-4 border border-dashed border-slate-200 rounded-lg md:rounded-2xl hover:bg-indigo-50 transition-all group flex items-center gap-2">
                        <i class="fas fa-user-plus text-indigo-500 text-xs md:text-base"></i>
                        <span class="text-[9px] md:text-sm font-bold text-slate-700 group-hover:text-indigo-700 uppercase italic">Guru</span>
                    </a>
                    <a href="#" class="p-2 md:p-4 border border-dashed border-slate-200 rounded-lg md:rounded-2xl hover:bg-emerald-50 transition-all group flex items-center gap-2">
                        <i class="fas fa-print text-emerald-500 text-xs md:text-base"></i>
                        <span class="text-[9px] md:text-sm font-bold text-slate-700 group-hover:text-emerald-700 uppercase italic">Cetak</span>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-900 p-4 md:p-8 rounded-2xl md:rounded-3xl shadow-xl text-white relative overflow-hidden flex flex-col justify-center">
    <div class="relative z-10 w-full">
        <h2 class="text-xs md:text-xl font-bold mb-1 md:mb-2 uppercase italic">Hubungi Kami</h2>
        <p class="text-indigo-300 text-[8px] md:text-sm mb-3 md:mb-6 leading-tight">Butuh bantuan cepat?</p>
        
        <div class="flex flex-col gap-1.5 md:gap-3">
            <a href="https://wa.me/" target="_blank" 
               class="bg-[#25D366] text-white px-2 md:px-4 py-1.5 md:py-2.5 rounded-lg font-bold text-[8px] md:text-sm hover:brightness-110 transition-all flex items-center justify-center gap-2 shadow-lg uppercase italic">
                <i class="fab fa-whatsapp text-[10px] md:text-base"></i>
                <span>WhatsApp</span>
            </a>

            <a href="https://instagram.com/gabrielhst_" target="_blank" 
               class="bg-gradient-to-r from-[#833ab4] via-[#fd1d1d] to-[#fcb045] text-white px-2 md:px-4 py-1.5 md:py-2.5 rounded-lg font-bold text-[8px] md:text-sm hover:brightness-110 transition-all flex items-center justify-center gap-2 shadow-lg uppercase italic">
                <i class="fab fa-instagram text-[10px] md:text-base"></i>
                <span>Instagram</span>
            </a>

            <a href="mailto:anosvldg17@gmail.com" 
               class="bg-white text-indigo-900 px-2 md:px-4 py-1.5 md:py-2.5 rounded-lg font-bold text-[8px] md:text-sm hover:bg-indigo-50 transition-all flex items-center justify-center gap-2 shadow-lg uppercase italic">
                <i class="fas fa-envelope text-[10px] md:text-base"></i>
                <span>Email Support</span>
            </a>
        </div>
    </div>
    
    <i class="fas fa-headset absolute -bottom-4 -right-4 text-5xl md:text-9xl text-indigo-800 opacity-30 pointer-events-none"></i>
</div>
        </div>

    </main>

</body>
</html>