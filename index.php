<?php
include 'koneksi.php';

$query_siswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM daftar_siswa");
$data_siswa = mysqli_fetch_assoc($query_siswa);

$query_avg = mysqli_query($conn, "SELECT AVG(nilai_akhir) AS rata_rata FROM daftar_nilai");
$data_avg = mysqli_fetch_assoc($query_avg);

$query_latest = mysqli_query($conn, "SELECT dn.*, ds.nama_siswa FROM daftar_nilai dn 
                                     JOIN daftar_siswa ds ON dn.id_siswa = ds.id_siswa 
                                     ORDER BY dn.id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Admin Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-h-screen p-6 lg:p-10">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang, Admin 👋</h1>
                <p class="text-slate-500 font-medium">Berikut adalah ringkasan performa akademik hari ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-200 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Total Siswa Terdaftar</p>
                        <h2 class="text-5xl font-black text-blue-600"><?= $data_siswa['total'] ?></h2>
                        <p class="text-xs text-slate-400 mt-2 font-medium">Siswa aktif di database</p>
                    </div>
                    <div class="absolute -right-4 -bottom-4 text-slate-50 group-hover:text-blue-50 transition-colors duration-300">
                        <i class="fas fa-users text-9xl"></i>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-200 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Rata-rata Nilai Sekolah</p>
                        <h2 class="text-5xl font-black text-emerald-600"><?= number_format($data_avg['rata_rata'] ?? 0, 1) ?></h2>
                        <p class="text-xs text-slate-400 mt-2 font-medium">Skala pencapaian 0 - 100</p>
                    </div>
                    <div class="absolute -right-4 -bottom-4 text-slate-50 group-hover:text-emerald-50 transition-colors duration-300">
                        <i class="fas fa-chart-line text-9xl"></i>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-xl shadow-slate-200 flex flex-col justify-center">
                    <p class="text-slate-400 text-sm mb-4">Butuh input data baru?</p>
                    <a href="tambah_daftar_nilai.php" class="bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-2xl font-bold transition-all active:scale-95 shadow-lg shadow-blue-500/30">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Nilai Baru
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800">Input Nilai Terbaru</h3>
                        <p class="text-sm text-slate-400 font-medium">5 Transaksi nilai terakhir yang dimasukkan.</p>
                    </div>
                    <a href="daftar_nilai.php" class="text-blue-600 font-bold text-sm hover:underline">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                <th class="px-8 py-4">Nama Siswa</th>
                                <th class="px-8 py-4">Mata Pelajaran</th>
                                <th class="px-8 py-4">Nilai Akhir</th>
                                <th class="px-8 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(mysqli_num_rows($query_latest) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($query_latest)): 
                                    $isPass = $row['nilai_akhir'] >= 75;
                                ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                <?= substr($row['nama_siswa'], 0, 1) ?>
                                            </div>
                                            <span class="font-bold text-slate-700"><?= $row['nama_siswa'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-slate-500 font-medium italic"><?= $row['mata_pelajaran'] ?></span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-lg font-black <?= $isPass ? 'text-slate-700' : 'text-red-600' ?>">
                                            <?= number_format($row['nilai_akhir'], 1) ?>
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <?php if($isPass): ?>
                                            <span class="bg-emerald-50 text-emerald-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter border border-emerald-100">
                                                Tuntas
                                            </span>
                                        <?php else: ?>
                                            <span class="bg-red-50 text-red-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter border border-red-100">
                                                Remedial
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic">Belum ada data nilai yang diinput.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>