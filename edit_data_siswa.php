<?php
include 'koneksi.php';

$id = $_GET['id'];
$query_siswa = mysqli_query($conn, "SELECT * FROM daftar_siswa WHERE id_siswa = $id");
$d = mysqli_fetch_assoc($query_siswa);

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
        header("Location: data_siswa.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa</title>
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
                <i class="fas fa-arrow-left"></i> Batal & Kembali
            </a>
            
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 lg:p-12">
                <div class="mb-10">
                    <h1 class="text-2xl font-extrabold text-slate-900 italic">Edit Profil Siswa</h1>
                    <p class="text-slate-500 mt-2 font-medium">Perbarui data NISN atau perpindahan kelas siswa.</p>
                </div>

                <form method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_siswa" value="<?= $d['nama_siswa'] ?>" required 
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">NISN</label>
                            <input type="number" name="nisn" value="<?= $d['nisn'] ?>" required 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold text-slate-400">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Kelas & Jurusan</label>
                            <input type="text" name="kelas_jurusan" value="<?= $d['kelas_jurusan'] ?>" required 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Alamat Domisili</label>
                        <textarea name="alamat" rows="3" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-semibold"><?= $d['alamat'] ?></textarea>
                    </div>

                    <button type="submit" name="update" 
                            class="w-full bg-slate-900 hover:bg-black text-white font-bold py-4 rounded-2xl shadow-lg transition-all active:scale-[0.98]">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>