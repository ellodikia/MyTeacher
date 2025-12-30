<?php
include 'koneksi.php';

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
    <title>Tambah Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">

<div class="flex min-h-screen">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-6 lg:p-10">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                    <i class="fas fa-plus-circle text-blue-600 mr-2"></i> Input Nilai Baru
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Silahkan pilih siswa dan masukkan detail komponen nilai.</p>
            </div>

            <form action="" method="POST" class="space-y-6">
                
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Pilih Nama Siswa</label>
                            <select name="id_siswa" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-slate-700" required>
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                <?php while($s = mysqli_fetch_assoc($siswa)): ?>
                                    <option value="<?= $s['id_siswa'] ?>"><?= $s['nama_siswa'] ?> (<?= $s['kelas_jurusan'] ?>)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" placeholder="Contoh: Pemrograman Web" 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-slate-700" required>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                        <div>
                            <h3 class="font-black text-slate-800 flex items-center gap-2 uppercase tracking-widest text-xs">
                                <i class="fas fa-tasks text-emerald-500"></i> Komponen Nilai Tugas
                            </h3>
                            <p class="text-[11px] text-slate-400 mt-1 font-medium">Input nilai tugas harian untuk rata-rata otomatis</p>
                        </div>
                        <button type="button" onclick="tambahTugas()" class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-black hover:bg-emerald-100 transition-colors uppercase flex items-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Baris
                        </button>
                    </div>

                    <div id="list-input-tugas" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-6">
                        <div class="relative group item-tugas">
                            <input type="number" step="0.1" min="0" max="100" placeholder="Tugas 1" oninput="hitungRataRata()"
                                   class="input-skor w-full px-3 py-4 bg-slate-50 border border-slate-200 rounded-xl text-center font-bold text-slate-700 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-2xl p-6 flex items-center justify-between text-white shadow-xl shadow-slate-200">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400">Nilai Harian (Rata-rata)</span>
                            <span class="text-[11px] text-slate-400">Otomatis terhitung dari komponen di atas</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="number" name="nilai_harian" id="hasil_harian" value="0" step="0.1" readonly 
                                   class="bg-transparent text-4xl font-black w-32 text-right outline-none text-emerald-400">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200 group hover:border-blue-300 transition-all">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3 text-center">Nilai UH</label>
                        <input type="number" name="nilai_uh" step="0.1" placeholder="0.0" required 
                               class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-2xl font-black text-slate-700 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition-all text-center">
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200 group hover:border-blue-300 transition-all">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3 text-center">Nilai UTS</label>
                        <input type="number" name="nilai_uts" step="0.1" placeholder="0.0" required 
                               class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-2xl font-black text-slate-700 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition-all text-center">
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200 group hover:border-blue-300 transition-all">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3 text-center">Nilai UAS</label>
                        <input type="number" name="nilai_uas" step="0.1" placeholder="0.0" required 
                               class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-2xl font-black text-slate-700 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition-all text-center">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button type="submit" name="simpan" class="flex-1 py-5 bg-blue-600 text-white rounded-3xl font-black text-lg hover:bg-blue-700 shadow-xl shadow-blue-200 transition-all active:scale-[0.98] uppercase tracking-widest flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i> Simpan Data Nilai
                    </button>
                    <a href="daftar_nilai.php" class="px-10 py-5 bg-white text-slate-500 border border-slate-200 rounded-3xl font-bold hover:bg-slate-50 transition-all uppercase text-sm flex items-center justify-center">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </main>
</div>

<script>
    function tambahTugas() {
        const container = document.getElementById('list-input-tugas');
        const count = container.querySelectorAll('.item-tugas').length + 1;
        
        const div = document.createElement('div');
        div.className = 'relative group item-tugas';
        div.innerHTML = `
            <input type="number" step="0.1" min="0" max="100" placeholder="Tugas ${count}" oninput="hitungRataRata()"
                   class="input-skor w-full px-3 py-4 bg-slate-50 border border-slate-200 rounded-xl text-center font-bold text-slate-700 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
            <button type="button" onclick="hapusTugas(this)" class="absolute -top-2 -right-2 bg-red-500 text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
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
        } else {
            alert('Minimal harus ada satu input tugas!');
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
        if(count > 0) {
            const rataRata = total / count;
            hasilHarian.value = rataRata.toFixed(1);
        } else {
            hasilHarian.value = 0;
        }
    }
</script>

</body>
</html>