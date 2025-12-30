<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include 'koneksi.php';

$id = $_GET['id'];

$query_ambil = mysqli_query($conn, "SELECT dn.*, ds.nama_siswa, ds.kelas_jurusan 
                                     FROM daftar_nilai dn 
                                     JOIN daftar_siswa ds ON dn.id_siswa = ds.id_siswa 
                                     WHERE dn.id=$id");
$d = mysqli_fetch_assoc($query_ambil);

if (!$d) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='daftar_nilai.php';</script>";
    exit;
}

if(isset($_POST['update'])) {
    $mapel = mysqli_real_escape_string($conn, $_POST['mata_pelajaran']);
    $n_harian = $_POST['nilai_harian'];
    $n_uh = $_POST['nilai_uh'];
    $n_uts = $_POST['nilai_uts'];
    $n_uas = $_POST['nilai_uas'];
    
    $n_akhir = ($n_harian + $n_uh + $n_uts + $n_uas) / 4;

    $sql_update = "UPDATE daftar_nilai SET 
                    mata_pelajaran='$mapel', 
                    nilai_harian='$n_harian', 
                    nilai_uh='$n_uh', 
                    nilai_uts='$n_uts', 
                    nilai_uas='$n_uas',
                    nilai_akhir='$n_akhir'
                    WHERE id=$id";

    if(mysqli_query($conn, $sql_update)) {
        header("Location: daftar_nilai.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-6">
                <a href="daftar_nilai.php" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors mb-4">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Nilai
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    <i class="fas fa-edit text-blue-600"></i> Edit Data Nilai
                </h1>
                <p class="text-slate-500 mt-1 font-medium">Mengubah data milik: <span class="text-slate-900 font-bold"><?= htmlspecialchars($d['nama_siswa']) ?></span></p>
            </div>

            <form action="" method="post" class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Lengkap</label>
                            <input type="text" value="<?= htmlspecialchars($d['nama_siswa']) ?>" disabled 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-400 cursor-not-allowed">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" value="<?= htmlspecialchars($d['mata_pelajaran']) ?>" required
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none font-bold text-slate-700">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest">
                            <i class="fas fa-calculator text-emerald-500 mr-2"></i> Kalkulator Harian
                        </h3>
                        <button type="button" onclick="tambahTugas()" class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-black hover:bg-emerald-100 transition-colors">
                            <i class="fas fa-plus"></i> Tambah Skor
                        </button>
                    </div>

                    <div id="list-input-tugas" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-6">
                        </div>

                    <div class="bg-slate-900 rounded-2xl p-6 flex items-center justify-between text-white shadow-xl shadow-slate-200">
                        <div>
                            <span class="text-[10px] font-black uppercase text-emerald-400 tracking-widest">Hasil Rata-Rata Harian</span>
                        </div>
                        <input type="number" name="nilai_harian" id="hasil_harian" value="<?= $d['nilai_harian'] ?>" step="0.1" readonly required 
                               class="bg-transparent text-4xl font-black w-32 text-right outline-none text-emerald-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3 ml-1 text-center">Nilai UH</label>
                        <input type="number" name="nilai_uh" value="<?= $d['nilai_uh'] ?>" step="0.1" required 
                               class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-2xl font-black text-center text-slate-700 focus:ring-4 focus:ring-blue-500/10 outline-none">
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3 ml-1 text-center">Nilai UTS</label>
                        <input type="number" name="nilai_uts" value="<?= $d['nilai_uts'] ?>" step="0.1" required 
                               class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-2xl font-black text-center text-slate-700 focus:ring-4 focus:ring-blue-500/10 outline-none">
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3 ml-1 text-center">Nilai UAS</label>
                        <input type="number" name="nilai_uas" value="<?= $d['nilai_uas'] ?>" step="0.1" required 
                               class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-2xl font-black text-center text-slate-700 focus:ring-4 focus:ring-blue-500/10 outline-none">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-4">
                    <button type="submit" name="update" class="flex-1 py-5 bg-blue-600 text-white rounded-3xl font-black text-lg hover:bg-blue-700 shadow-xl shadow-blue-200 transition-all active:scale-[0.98] uppercase tracking-widest flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="daftar_nilai.php" class="px-10 py-5 bg-white text-slate-500 border border-slate-200 rounded-3xl font-bold hover:bg-slate-50 transition-colors uppercase text-sm flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

<script>
// (Script JavaScript tetap sama untuk fungsionalitas kalkulator)
function tambahTugas() {
    const container = document.getElementById('list-input-tugas');
    const div = document.createElement('div');
    div.className = 'relative group item-tugas';
    div.innerHTML = `
        <input type="number" step="0.1" min="0" max="100" placeholder="0.0" oninput="hitungRataRata()"
               class="input-skor w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-center font-bold text-slate-700 focus:ring-2 focus:ring-emerald-400 outline-none">
        <button type="button" onclick="hapusTugas(this)" class="absolute -top-2 -right-2 bg-red-500 text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

function hapusTugas(btn) {
    btn.closest('.item-tugas').remove();
    hitungRataRata();
}

function hitungRataRata() {
    const inputs = document.querySelectorAll('.input-skor');
    let total = 0;
    let count = 0;
    inputs.forEach(input => {
        if(input.value !== "") {
            total += parseFloat(input.value);
            count++;
        }
    });
    if (count > 0) {
        document.getElementById('hasil_harian').value = (total / count).toFixed(1);
    }
}
</script>
</body>
</html>