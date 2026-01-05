<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: data_siswa.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query_siswa = mysqli_query($conn, "SELECT * FROM daftar_siswa WHERE id_siswa = $id");
$d = mysqli_fetch_assoc($query_siswa);

if (!$d) {
    header("Location: data_siswa.php");
    exit;
}

if(isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas_jurusan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $update = "UPDATE daftar_siswa SET 
                nama_siswa='$nama', 
                nisn='$nisn', 
                kelas_jurusan='$kelas', 
                alamat='$alamat' 
                WHERE id_siswa = $id";

    if(mysqli_query($conn, $update)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='data_siswa.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Edit Siswa - MYTEACHER</title>
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
                <a href="data_siswa.php" class="inline-flex items-center gap-3 text-slate-500 hover:text-blue-600 mb-8 transition-all font-bold group">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </div>
                    Batal & Kembali
                </a>
                
                <div class="bg-white rounded-[3rem] shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-900 p-8 md:p-10 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h1 class="text-2xl md:text-3xl font-black tracking-tight">Perbarui Profil</h1>
                            <p class="text-slate-400 mt-2 font-medium">Mengedit data siswa: <span class="text-blue-400"><?= $d['nama_siswa'] ?></span></p>
                        </div>
                        <i class="fas fa-user-edit absolute right-[-20px] bottom-[-20px] text-8xl text-white/5 rotate-12"></i>
                    </div>

                    <form method="POST" class="p-8 md:p-10 space-y-7">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">Nama Lengkap Siswa</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="nama_siswa" value="<?= $d['nama_siswa'] ?>" required 
                                       class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">NISN (10 Digit)</label>
                                <div class="relative">
                                    <i class="fas fa-id-card absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="text" name="nisn" value="<?= $d['nisn'] ?>" required maxlength="10"
                                           onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                           class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">Kelas & Jurusan</label>
                                <div class="relative">
                                    <i class="fas fa-graduation-cap absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="text" name="kelas_jurusan" value="<?= $d['kelas_jurusan'] ?>" required 
                                           class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 uppercase">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] ml-2">Alamat Domisili</label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-5 top-5 text-slate-300"></i>
                                <textarea name="alamat" rows="3" 
                                          class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 resize-none"><?= $d['alamat'] ?></textarea>
                            </div>
                        </div>

                        <div class="pt-4 flex flex-col md:flex-row gap-4">
                            <button type="submit" name="update" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-100 transition-all active:scale-[0.97] flex items-center justify-center gap-3 tracking-widest uppercase text-sm">
                                <i class="fas fa-check-circle"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em] mt-10">Akun dikelola oleh Guru</p>
            </div>
        </main>
    </div>

    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

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