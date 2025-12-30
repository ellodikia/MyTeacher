<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include 'koneksi.php';

if(isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas_jurusan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "INSERT INTO daftar_siswa (nama_siswa, nisn, kelas_jurusan, alamat) 
              VALUES ('$nama', '$nisn', '$kelas', '$alamat')";

    if(mysqli_query($conn, $query)) {
        header("Location: data_siswa.php");
    } else {
        $error = "Gagal menambah data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-6 lg:p-10">
        <div class="max-w-2xl mx-auto">
            <a href="data_siswa.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 mb-6 transition-colors font-semibold">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 lg:p-12">
                <div class="mb-10 text-center">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Registrasi Siswa Baru</h1>
                    <p class="text-slate-500 mt-2 font-medium">Lengkapi biodata dasar siswa di bawah ini.</p>
                </div>

                <form method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_siswa" required placeholder="Contoh: Ahmad Subardjo" 
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">NISN (10 Digit)</label>
                            <input type="number" name="nisn" required placeholder="0012345xxx" 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Kelas & Jurusan</label>
                            <input type="text" name="kelas_jurusan" required placeholder="XII RPL 1" 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Alamat Domisili</label>
                        <textarea name="alamat" rows="3" placeholder="Jl. Merdeka No. 12..." 
                                  class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold"></textarea>
                    </div>

                    <button type="submit" name="simpan" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all active:scale-[0.98]">
                        Simpan Data Siswa
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>