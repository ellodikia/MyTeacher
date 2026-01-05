<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

if(isset($_POST['simpan'])){
    $id_siswa = $_POST['id_siswa'];
    $mapel = mysqli_real_escape_string($conn, $_POST['mata_pelajaran']);
    $harian = $_POST['nilai_harian']; 
    $uh = $_POST['nilai_uh'];
    $uts = $_POST['nilai_uts'];
    $uas = $_POST['nilai_uas'];
    
    $akhir = ($harian + $uh + $uts + $uas) / 4;

    $sql = "INSERT INTO daftar_nilai (id_siswa, mata_pelajaran, nilai_harian, nilai_uh, nilai_uts, nilai_uas, nilai_akhir) 
            VALUES ('$id_siswa', '$mapel', '$harian', '$uh', '$uts', '$uas', '$akhir')";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='daftar_nilai.php';</script>";
    }
}
$siswa = mysqli_query($conn, "SELECT * FROM daftar_siswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Tambah Nilai - MYTEACHER.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
                    <h1 class="text-xl md:text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                        <i class="fas fa-plus-circle text-blue-600"></i> Input Nilai Baru
                    </h1>
                    <p class="text-slate-500 text-xs md:text-sm mt-1 font-medium">Masukkan komponen nilai siswa dengan teliti.</p>
                </div>

                <form action="" method="POST" class="space-y-4 md:space-y-6">
                    
                    <div class="bg-white p-5 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-slate-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest ml-1">Pilih Siswa</label>
                                <select name="id_siswa" class="w-full px-3 py-3 md:px-5 md:py-4 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl focus:ring-4 focus:ring-blue-500/10 outline-none font-bold text-slate-700 text-xs md:text-base transition-all" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <?php while($s = mysqli_fetch_assoc($siswa)): ?>
                                        <option value="<?= $s['id_siswa'] ?>"><?= $s['nama_siswa'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest ml-1">Mata Pelajaran</label>
                                <input type="text" name="mata_pelajaran" placeholder="Mapel" 
                                       class="w-full px-3 py-3 md:px-5 md:py-4 bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl focus:ring-4 focus:ring-blue-500/10 outline-none font-bold text-slate-700 text-xs md:text-base transition-all" required>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 md:p-8 rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-slate-200 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500"></div>
                        
                        <div class="flex justify-between items-center mb-4 md:mb-6">
                            <h3 class="font-black text-slate-800 uppercase text-[10px] tracking-widest flex items-center gap-2">
                                <i class="fas fa-tasks text-emerald-500"></i> Rata-rata Harian
                            </h3>
                            <button type="button" onclick="tambahTugas()" class="px-3 py-1.5 md:px-4 md:py-2 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black hover:bg-emerald-100 transition-all uppercase">
                                <i class="fas fa-plus mr-1"></i> Baris
                            </button>
                        </div>

                        <div id="list-input-tugas" class="grid grid-cols-4 md:grid-cols-6 gap-2 md:gap-3 mb-4 md:mb-6">
                            <div class="relative group item-tugas">
                                <input type="number" step="0.1" min="0" max="100" placeholder="0" oninput="hitungRataRata()"
                                       class="input-skor w-full px-2 py-3 bg-slate-50 border border-slate-200 rounded-lg md:rounded-xl text-center font-bold text-slate-700 text-xs outline-none focus:border-emerald-400 transition-all">
                            </div>
                        </div>

                        <div class="bg-slate-900 rounded-xl md:rounded-[2rem] p-4 md:p-6 flex items-center justify-between text-white shadow-lg">
                            <span class="text-[9px] md:text-[10px] font-black uppercase text-emerald-400 tracking-widest">Skor Harian</span>
                            <input type="number" name="nilai_harian" id="hasil_harian" value="0" step="0.1" readonly 
                                   class="bg-transparent text-2xl md:text-4xl font-black w-24 text-right outline-none text-emerald-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 md:gap-6">
                        <div class="bg-white p-3 md:p-6 rounded-[1.2rem] md:rounded-[2rem] shadow-sm border border-slate-200 text-center">
                            <label class="block text-[8px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Skor UH</label>
                            <input type="number" name="nilai_uh" step="0.1" placeholder="0" required 
                                   class="w-full bg-transparent text-lg md:text-2xl font-black text-slate-700 text-center outline-none">
                        </div>
                        <div class="bg-white p-3 md:p-6 rounded-[1.2rem] md:rounded-[2rem] shadow-sm border border-slate-200 text-center">
                            <label class="block text-[8px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Skor UTS</label>
                            <input type="number" name="nilai_uts" step="0.1" placeholder="0" required 
                                   class="w-full bg-transparent text-lg md:text-2xl font-black text-slate-700 text-center outline-none">
                        </div>
                        <div class="bg-white p-3 md:p-6 rounded-[1.2rem] md:rounded-[2rem] shadow-sm border border-slate-200 text-center">
                            <label class="block text-[8px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Skor UAS</label>
                            <input type="number" name="nilai_uas" step="0.1" placeholder="0" required 
                                   class="w-full bg-transparent text-lg md:text-2xl font-black text-slate-700 text-center outline-none">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="daftar_nilai.php" class="flex-1 py-3 md:py-5 bg-white text-slate-400 border border-slate-200 rounded-xl md:rounded-[2rem] font-bold text-[10px] md:text-xs uppercase tracking-widest flex items-center justify-center">
                            Batal
                        </a>
                        <button type="submit" name="simpan" class="flex-[2] py-3 md:py-5 bg-blue-600 text-white rounded-xl md:rounded-[2rem] font-black text-[10px] md:text-sm shadow-lg shadow-blue-100 uppercase tracking-widest flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Data
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
        const count = container.querySelectorAll('.item-tugas').length + 1;
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
        const inputs = document.querySelectorAll('.item-tugas');
        if(inputs.length > 1) {
            btn.closest('.item-tugas').remove();
            hitungRataRata();
        }
    }

    function hitungRataRata() {
        const allScores = document.querySelectorAll('.input-skor');
        let total = 0;
        let count = 0;
        allScores.forEach(input => {
            if(input.value !== "" && !isNaN(input.value)) {
                total += parseFloat(input.value);
                count++;
            }
        });
        const hasilHarian = document.getElementById('hasil_harian');
        hasilHarian.value = count > 0 ? (total / count).toFixed(1) : 0;
    }
</script>

</body>
</html>