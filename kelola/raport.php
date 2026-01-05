<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php'; 

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
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Ranking Siswa - MYTEACHER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* GARIS SCROLL INDIKATOR (Sesuai Kursor di Foto) */
        .scroll-container {
            position: relative;
            padding-bottom: 10px;
        }

        /* Garis abu-abu panjang sebagai dasar */
        .scroll-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #e2e8f0;
            border-radius: 2px;
        }

        /* Gaya Scrollbar untuk Chrome/Safari (Mobile & Desktop) */
        .tab-wrapper::-webkit-scrollbar {
            height: 3px; /* Ukuran garis scroll biru */
        }
        .tab-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }
        .tab-wrapper::-webkit-scrollbar-thumb {
            background: #2563eb; /* Warna biru sesuai kursor */
            border-radius: 10px;
        }

        .tab-active { 
            background-color: #2563eb !important; 
            color: white !important;
        }

        /* Pastikan Sidebar tetap konsisten (Lebar 280px seperti standar dashboard) */
        @media (min-width: 1024px) {
            .sidebar-fixed { width: 280px; min-width: 280px; }
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 flex flex-col lg:flex-row min-h-screen">

    <div class="sidebar-fixed h-full bg-slate-900">
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
        <header class="lg:hidden flex items-center justify-between bg-slate-900 text-white px-6 py-5 sticky top-0 z-30 shadow-md h-[72px]">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-blue-600 rounded-md">
                    <i class="fas fa-chalkboard-teacher text-sm"></i>
                </div>
                <span class="font-black tracking-tight">MY<span class="text-blue-500">TEACHER.</span></span>
            </div>
            <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center bg-slate-800 rounded-xl">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </header>

        <main class="p-6 md:p-10">
            <div class="max-w-7xl mx-auto">
                
                <div class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                        <i class="fas fa-trophy text-yellow-500"></i> Peringkat Siswa
                    </h1>
                </div>

                <?php if (!empty($data_raport)): ?>
                    <div class="mb-10">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Pilih Kelas</p>
                        
                        <div class="scroll-container">
                            <div class="tab-wrapper flex items-center gap-2 overflow-x-auto pb-4 scroll-smooth">
                                <?php foreach ($daftar_kelas as $index => $kelas): ?>
                                    <button onclick="showTab('<?= str_replace(' ', '-', $kelas) ?>', this)" 
                                            class="tab-btn whitespace-nowrap px-6 py-3 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-500 transition-all <?= $index === 0 ? 'tab-active' : '' ?>">
                                        <?= htmlspecialchars($kelas) ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($data_raport as $kelas => $daftar_siswa): ?>
                    <div id="content-<?= str_replace(' ', '-', $kelas) ?>" class="tab-content <?= array_search($kelas, $daftar_kelas) === 0 ? '' : 'hidden' ?>">
                        
                        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left min-w-[700px]">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-100 uppercase text-[10px] font-black text-slate-400 tracking-widest">
                                            <th class="px-8 py-5 text-center w-24">Rank</th>
                                            <th class="px-6 py-5">Identitas Siswa</th>
                                            <th class="px-6 py-5 text-center">Rata-rata</th>
                                            <th class="px-6 py-5 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <?php 
                                        $rank = 1;
                                        foreach ($daftar_siswa as $s): 
                                            $medalColor = $rank == 1 ? 'text-yellow-500' : ($rank == 2 ? 'text-slate-400' : ($rank == 3 ? 'text-orange-400' : 'text-slate-200'));
                                        ?>
                                        <tr class="hover:bg-slate-50/50 transition-all">
                                            <td class="px-8 py-6 text-center">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas fa-medal <?= $medalColor ?> text-3xl"></i>
                                                    <span class="text-[9px] font-black text-slate-400 mt-1 uppercase">#<?= $rank ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-800 text-base"><?= htmlspecialchars($s['nama_siswa']) ?></span>
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase">NISN: <?= $s['nisn'] ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <div class="inline-block px-5 py-2.5 bg-blue-50 text-blue-600 rounded-xl font-black text-xl border border-blue-100">
                                                    <?= number_format($s['rata_rata_umum'], 1) ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <?php if($s['rata_rata_umum'] >= 75): ?>
                                                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Kompeten</span>
                                                <?php else: ?>
                                                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Remidi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php $rank++; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
        }

        function showTab(kelasId, btn) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-active'));
            document.getElementById('content-' + kelasId).classList.remove('hidden');
            btn.classList.add('tab-active');
            btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    </script>
</body>
</html>