<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include 'koneksi.php';

$query = "SELECT 
            ds.id_siswa,
            ds.nama_siswa, 
            ds.kelas_jurusan, 
            ds.nisn,
            AVG(dn.nilai_akhir) as rata_rata_umum
          FROM daftar_siswa ds
          JOIN daftar_nilai dn ON ds.id_siswa = dn.id_siswa
          GROUP BY ds.id_siswa
          ORDER BY ds.kelas_jurusan ASC, rata_rata_umum DESC";

$result = mysqli_query($conn, $query);

$data_raport = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_raport[$row['kelas_jurusan']][] = $row;
}

$daftar_kelas = array_keys($data_raport);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Siswa - Raport</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .tab-active { 
            background-color: #2563eb !important; 
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">

<div class="flex min-h-screen">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-6 lg:p-10">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i> Peringkat Siswa
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Pilih kelas di bawah ini untuk melihat daftar ranking.</p>
            </div>

            <?php if (empty($data_raport)): ?>
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 text-center">
                    <img src="https://illustrations.popsy.co/slate/list-is-empty.svg" class="w-48 mx-auto mb-4" alt="Empty">
                    <p class="text-slate-500 font-bold">Belum ada data nilai yang diinputkan.</p>
                </div>
            <?php else: ?>
                
                <div class="flex flex-wrap gap-2 mb-8 bg-white p-3 rounded-3xl border border-slate-200 shadow-sm">
                    <?php foreach ($daftar_kelas as $index => $kelas): ?>
                        <button onclick="showTab('<?= str_replace(' ', '-', $kelas) ?>', this)" 
                                class="tab-btn px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all uppercase tracking-wider <?= $index === 0 ? 'tab-active' : '' ?>">
                            <?= htmlspecialchars($kelas) ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($data_raport as $kelas => $daftar_siswa): ?>
                <div id="content-<?= str_replace(' ', '-', $kelas) ?>" 
                     class="tab-content animate-in fade-in slide-in-from-bottom-4 duration-500 <?= array_search($kelas, $daftar_kelas) === 0 ? '' : 'hidden' ?>">
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-10 w-1.5 bg-blue-600 rounded-full"></div>
                        <h2 class="text-2xl font-extrabold text-slate-800 italic uppercase">Daftar Rangking <?= htmlspecialchars($kelas) ?></h2>
                    </div>

                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center w-24">Rank</th>
                                    <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Identitas Siswa</th>
                                    <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Rata-rata Nilai</th>
                                    <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Status Akademik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php 
                                $rank = 1;
                                foreach ($daftar_siswa as $s): 
                                    $bgColor = '';
                                    $icon = '';
                                    if($rank == 1) { $bgColor = 'bg-yellow-50/30'; $icon = 'text-yellow-500'; }
                                    elseif($rank == 2) { $bgColor = 'bg-slate-50/50'; $icon = 'text-slate-400'; }
                                    elseif($rank == 3) { $bgColor = 'bg-orange-50/30'; $icon = 'text-orange-400'; }
                                ?>
                                <tr class="hover:bg-slate-50/80 transition-colors <?= $bgColor ?>">
                                    <td class="px-8 py-6 text-center">
                                        <?php if($rank <= 3): ?>
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-medal <?= $icon ?> text-3xl drop-shadow-sm"></i>
                                                <span class="text-[10px] font-black mt-1 text-slate-400">JUARA <?= $rank ?></span>
                                            </div>
                                        <?php else: ?>
                                            <span class="font-black text-slate-300 text-xl">#<?= $rank ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-black text-lg">
                                                <?= substr($s['nama_siswa'], 0, 1) ?>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800 text-lg leading-tight"><?= htmlspecialchars($s['nama_siswa']) ?></span>
                                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">NISN: <?= $s['nisn'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <div class="inline-block px-5 py-2 bg-slate-900 text-white rounded-2xl font-black text-2xl shadow-lg shadow-slate-200">
                                            <?= number_format($s['rata_rata_umum'], 1) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <?php if($s['rata_rata_umum'] >= 85): ?>
                                            <span class="px-4 py-2 bg-emerald-100 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200">Sangat Baik</span>
                                        <?php elseif($s['rata_rata_umum'] >= 75): ?>
                                            <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-200">Cukup</span>
                                        <?php else: ?>
                                            <span class="px-4 py-2 bg-rose-100 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-200">Perlu Bimbingan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php 
                                $rank++;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </main>
</div>

<script>
    function showTab(kelasId, btn) {
        // Sembunyikan semua konten tabel
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.add('hidden'));

        // Hapus class active dari semua tombol
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(button => button.classList.remove('tab-active'));

        // Tampilkan konten yang dipilih
        document.getElementById('content-' + kelasId).classList.remove('hidden');

        // Tambahkan class active ke tombol yang diklik
        btn.classList.add('tab-active');
    }
</script>

</body>
</html>