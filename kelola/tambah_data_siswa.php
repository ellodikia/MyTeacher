<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

$error = "";

if(isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas_jurusan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $cek_nisn = mysqli_query($conn, "SELECT nisn FROM daftar_siswa WHERE nisn = '$nisn'");
    if(mysqli_num_rows($cek_nisn) > 0) {
        $error = "NISN sudah terdaftar di sistem!";
    } else {
        $query = "INSERT INTO daftar_siswa (nama_siswa, nisn, kelas_jurusan, alamat) 
                  VALUES ('$nama', '$nisn', '$kelas', '$alamat')";

        if(mysqli_query($conn, $query)) {
            header("Location: data_siswa.php");
            exit;
        } else {
            $error = "Gagal menambah data: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Tambah Siswa - MYTEACHER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex flex-col lg:flex-row min-h-screen">

    <?php include 'sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="lg:hidden flex items-center justify-between bg-slate-900 text-white px-6 py-4 sticky top-0 z-30 shadow-md">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-blue-600 rounded-md">
                    <i class="fas fa-chalkboard-teacher text-sm"></i>
                </div>
                <span class="font-black tracking-tight">MY<span class="text-blue-500">TEACHER.</span></span>
            </div>
            <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center bg-slate-800 rounded-xl active:scale-95 transition-all">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </header>

        <main class="p-4 md:p-8 lg:p-10">
            <div class="max-w-2xl mx-auto">
                <a href="data_siswa.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 mb-8 transition-colors font-bold text-sm group">
                    <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Kembali ke Daftar Siswa
                </a>
                
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-6 md:p-10 lg:p-12">
                    <div class="mb-10 text-center">
                        <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <i class="fas fa-user-plus text-3xl"></i>
                        </div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Registrasi Siswa</h1>
                        <p class="text-slate-500 mt-2 font-medium">Lengkapi biodata dasar siswa untuk membuat akun akademik.</p>
                    </div>

                    <?php if($error !== ""): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl flex items-center gap-3 text-sm font-bold animate-pulse">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">Nama Lengkap Siswa</label>
                            <input type="text" name="nama_siswa" required placeholder="Contoh: Ahmad Subardjo" 
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-300">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">NISN (10 Digit)</label>
                                <input type="text" name="nisn" required maxlength="10" minlength="10" placeholder="0012345xxx" 
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                       class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-300">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">Kelas & Jurusan</label>
                                <input type="text" name="kelas_jurusan" required placeholder="Contoh: XII RPL" 
                                       class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-300">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">Alamat Domisili</label>
                            <textarea name="alamat" rows="3" placeholder="Jl. Merdeka No. 12, Kelurahan Kota..." 
                                      class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-300 resize-none"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" name="simpan" 
                                    class="w-full bg-slate-900 hover:bg-blue-600 text-white font-black py-5 rounded-2xl shadow-xl shadow-slate-200 transition-all active:scale-[0.97] flex items-center justify-center gap-3 tracking-wider uppercase text-sm">
                                <i class="fas fa-save"></i>
                                Simpan Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if(sidebar) sidebar.classList.toggle('-translate-x-full');
            if(overlay) overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>