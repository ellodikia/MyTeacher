<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

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
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Edit Nilai - MYTEACHER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Memastikan input angka tidak memiliki spinner di beberapa browser */
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-[#f8fafc] flex flex-col lg:flex-row min-h-screen">

    <?php include 'sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="lg:hidden flex items-center justify-between bg-slate-900 text-white px-5 py-4 sticky top-0 z-30 shadow-md">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-blue-600 rounded-md">
                    <i class="fas fa-chalkboard-teacher text-sm"></i>
                </div>
                <span class="font-black tracking-tight">MY<span class="text-blue-500">TEACHER.</span></span>
            </div>
            <button onclick="toggleSidebar()" class="w-9 h-9 flex items-center justify-center bg-slate-800 rounded-lg">
                <i class="fas fa-bars text-sm"></i>
            </button>
        </header>

        <main class="p-4 md:p-8 lg:p-10">
            <div class="max-w-4xl mx-auto">
                
                <div class="mb-6">
                    <a href="daftar_nilai.php" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 mb-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="text-xl md:text-3xl font-black text-slate-900 tracking-tight">Edit Nilai</h1>
                    <p class="text-slate-500 text-xs md:text-sm font-medium mt-1 uppercase tracking-wider">Siswa: <?= htmlspecialchars($d['nama_siswa']) ?></p>
                </div>

                <form action="" method="post" class="space-y-4 md:space-y-6">
                    <div class="bg-white p-5 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-slate-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest">Nama Siswa</label>
                                <input type="text" value="<?= htmlspecialchars($d['nama_siswa']) ?>" disabled 
                                       class="w-full px-3 py-3 md:px-5 md:py-4 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl font-bold text-slate-400 text-xs md:text-base">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest">Mapel</label>
                                <input type="text" name="mata_pelajaran" value="<?= htmlspecialchars($d['mata_pelajaran']) ?>" required
                                       class="w-full px-3 py-3 md:px-5 md:py-4 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl font-bold text-slate-700 text-xs md:text-base outline-none focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 md:p-8 rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-slate-200">
                        <div class="flex justify-between items-center mb-4 md:mb-6">
                            <h3 class="font-black text-slate-800 uppercase text-[10px] tracking-widest flex items-center gap-2">
                                <i class="fas fa-calculator text-emerald-500"></i> Harian
                            </h3>
                            <button type="button" onclick="tambahTugas()" class="px-3 py-1.5 md:px-4 md:py-2 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black hover:bg-emerald-100 transition-all">
                                + Skor
                            </button>
                        </div>

                        <div id="list-input-tugas" class="grid grid-cols-4 md:grid-cols-6 gap-2 md:gap-3 mb-4 md:mb-6">
                            </div>

                        <div class="bg-slate-900 rounded-xl md:rounded-[2rem] p-4 md:p-6 flex items-center justify-between text-white">
                            <span class="text-[9px] md:text-[10px] font-black uppercase text-emerald-400 tracking-widest">Rata-Rata</span>
                            <input type="number" name="nilai_harian" id="hasil_harian" value="<?= $d['nilai_harian'] ?>" step="0.1" readonly required 
                                   class="bg-transparent text-2xl md:text-4xl font-black w-24 text-right outline-none text-emerald-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 md:gap-6">
                        <div class="bg-white p-3 md:p-6 rounded-[1.2rem] md:rounded-[2rem] shadow-sm border border-slate-200 text-center">
                            <label class="block text-[8px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">UH</label>
                            <input type="number" name="nilai_uh" value="<?= $d['nilai_uh'] ?>" step="0.1" required 
                                   class="w-full bg-transparent text-lg md:text-2xl font-black text-slate-700 outline-none">
                        </div>
                        <div class="bg-white p-3 md:p-6 rounded-[1.2rem] md:rounded-[2rem] shadow-sm border border-slate-200 text-center">
                            <label class="block text-[8px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">UTS</label>
                            <input type="number" name="nilai_uts" value="<?= $d['nilai_uts'] ?>" step="0.1" required 
                                   class="w-full bg-transparent text-lg md:text-2xl font-black text-slate-700 outline-none">
                        </div>
                        <div class="bg-white p-3 md:p-6 rounded-[1.2rem] md:rounded-[2rem] shadow-sm border border-slate-200 text-center">
                            <label class="block text-[8px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">UAS</label>
                            <input type="number" name="nilai_uas" value="<?= $d['nilai_uas'] ?>" step="0.1" required 
                                   class="w-full bg-transparent text-lg md:text-2xl font-black text-slate-700 outline-none">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="daftar_nilai.php" class="flex-1 py-3 md:py-5 bg-white text-slate-400 border border-slate-200 rounded-xl md:rounded-[2rem] font-bold text-[10px] md:text-xs uppercase tracking-widest flex items-center justify-center">
                            Batal
                        </a>
                        <button type="submit" name="update" class="flex-[2] py-3 md:py-5 bg-blue-600 text-white rounded-xl md:rounded-[2rem] font-black text-[10px] md:text-sm shadow-lg shadow-blue-100 uppercase tracking-widest flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
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

function tambahTugas() {
    const container = document.getElementById('list-input-tugas');
    const div = document.createElement('div');
    div.className = 'relative item-tugas';
    div.innerHTML = `
        <input type="number" step="0.1" min="0" max="100" placeholder="0" oninput="hitungRataRata()"
               class="input-skor w-full px-2 py-3 bg-slate-50 border border-slate-100 rounded-lg text-center font-bold text-slate-700 text-xs outline-none focus:border-emerald-400">
        <button type="button" onclick="hapusTugas(this)" class="absolute -top-1 -right-1 bg-red-500 text-white w-4 h-4 rounded-full text-[8px] flex items-center justify-center">
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