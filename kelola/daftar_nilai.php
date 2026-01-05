<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

$list_kelas = mysqli_query($conn, "SELECT DISTINCT kelas_jurusan FROM daftar_siswa ORDER BY kelas_jurusan");
$list_mapel = mysqli_query($conn, "SELECT DISTINCT mata_pelajaran FROM daftar_nilai ORDER BY mata_pelajaran");

$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$filter_mapel = isset($_GET['mapel']) ? $_GET['mapel'] : '';

$query = "SELECT dn.*, ds.nama_siswa, ds.kelas_jurusan 
          FROM daftar_nilai dn
          JOIN daftar_siswa ds ON dn.id_siswa = ds.id_siswa WHERE 1=1";

if ($filter_kelas != '') {
    $query .= " AND ds.kelas_jurusan = '$filter_kelas'";
}
if ($filter_mapel != '') {
    $query .= " AND dn.mata_pelajaran = '$filter_mapel'";
}

$query .= " ORDER BY dn.id DESC";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Daftar Nilai Siswa - MYTEACHER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media (max-width: 1024px) {
            .sidebar-open { overflow: hidden; }
        }
    </style>
</head>
<body class="bg-[#f1f5f9] flex flex-col lg:flex-row min-h-screen">

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
            <div class="max-w-7xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Nilai Siswa</h1>
                        <p class="text-slate-500 font-medium">Monitoring nilai UTS & UAS secara real-time.</p>
                    </div>
                    <a href="tambah_daftar_nilai.php" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95 text-sm">
                        <i class="fas fa-plus text-xs"></i> Tambah Nilai
                    </a>
                </div>

                <div class="bg-white p-5 md:p-8 rounded-[2rem] shadow-sm border border-slate-200 mb-10">
                    <form method="GET" class="flex flex-col lg:flex-row items-end gap-5">
                        <div class="w-full lg:flex-1">
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Pilih Kelas & Jurusan</label>
                            <select name="kelas" class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-semibold text-slate-700 appearance-none">
                                <option value="">Semua Kelas</option>
                                <?php while($k = mysqli_fetch_assoc($list_kelas)): ?>
                                    <option value="<?= $k['kelas_jurusan'] ?>" <?= $filter_kelas == $k['kelas_jurusan'] ? 'selected' : '' ?>><?= $k['kelas_jurusan'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="w-full lg:flex-1">
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Pilih Mata Pelajaran</label>
                            <select name="mapel" class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-semibold text-slate-700 appearance-none">
                                <option value="">Semua Mapel</option>
                                <?php while($m = mysqli_fetch_assoc($list_mapel)): ?>
                                    <option value="<?= $m['mata_pelajaran'] ?>" <?= $filter_mapel == $m['mata_pelajaran'] ? 'selected' : '' ?>><?= $m['mata_pelajaran'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="flex gap-3 w-full lg:w-auto">
                            <button type="submit" class="flex-1 lg:flex-none bg-slate-800 text-white px-10 py-3.5 rounded-xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-100">
                                Cari
                            </button>
                            <?php if($filter_kelas != '' || $filter_mapel != ''): ?>
                                <a href="daftar_nilai.php" class="flex items-center justify-center w-14 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all border border-red-100" title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8">
                    <?php if(mysqli_num_rows($data) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($data)) : 
                            $isRemedUTS = $row['nilai_uts'] < 75;
                            $isRemedUAS = $row['nilai_uas'] < 75;
                            $cardTheme = ($isRemedUTS || $isRemedUAS) ? 'red' : 'blue';
                        ?>
                        
                        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                            <div class="p-6 border-b border-slate-50">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 flex items-center justify-center bg-<?= $cardTheme ?>-50 rounded-2xl text-<?= $cardTheme ?>-600">
                                        <i class="fas fa-user-graduate text-xl"></i>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="edit_nilai.php?id=<?= $row['id'] ?>" class="w-9 h-9 flex items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 hover:bg-yellow-600 hover:text-white transition-all">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        <a href="hapus_nilai.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data?')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                                <h3 class="text-lg font-extrabold text-slate-800 leading-tight mb-2 truncate"><?= $row['nama_siswa'] ?></h3>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-wider"><?= $row['kelas_jurusan'] ?></span>
                                    <span class="text-slate-500 text-xs font-bold italic truncate max-w-[150px]"><?= $row['mata_pelajaran'] ?></span>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-slate-50/50 grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status UTS</span>
                                    <span class="flex items-center gap-1.5 <?= $isRemedUTS ? 'text-red-600' : 'text-emerald-600' ?> font-bold text-[11px]">
                                        <i class="fas <?= $isRemedUTS ? 'fa-times-circle' : 'fa-check-circle' ?>"></i> <?= $isRemedUTS ? 'REMEDIAL' : 'TUNTAS' ?>
                                    </span>
                                </div>
                                <div class="flex flex-col text-right border-l border-slate-200 pl-4">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status UAS</span>
                                    <span class="flex items-center justify-end gap-1.5 <?= $isRemedUAS ? 'text-red-600' : 'text-emerald-600' ?> font-bold text-[11px]">
                                        <?= $isRemedUAS ? 'REMEDIAL' : 'TUNTAS' ?> <i class="fas <?= $isRemedUAS ? 'fa-times-circle' : 'fa-check-circle' ?>"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 mt-auto">
                                <div class="grid grid-cols-4 gap-2 mb-6 text-center">
                                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                        <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Hrn</p>
                                        <p class="text-xs font-bold text-slate-700"><?= $row['nilai_harian'] ?></p>
                                    </div>
                                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                        <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">UH</p>
                                        <p class="text-xs font-bold text-slate-700"><?= $row['nilai_uh'] ?></p>
                                    </div>
                                    <div class="p-2 rounded-xl <?= $isRemedUTS ? 'bg-red-50 border-red-100' : 'bg-blue-50 border-blue-100' ?>">
                                        <p class="text-[8px] font-bold <?= $isRemedUTS ? 'text-red-400' : 'text-blue-400' ?> uppercase mb-1">UTS</p>
                                        <p class="text-xs font-black <?= $isRemedUTS ? 'text-red-600' : 'text-blue-600' ?>"><?= $row['nilai_uts'] ?></p>
                                    </div>
                                    <div class="p-2 rounded-xl <?= $isRemedUAS ? 'bg-red-50 border-red-100' : 'bg-blue-50 border-blue-100' ?>">
                                        <p class="text-[8px] font-bold <?= $isRemedUAS ? 'text-red-400' : 'text-blue-400' ?> uppercase mb-1">UAS</p>
                                        <p class="text-xs font-black <?= $isRemedUAS ? 'text-red-600' : 'text-blue-600' ?>"><?= $row['nilai_uas'] ?></p>
                                    </div>
                                </div>

                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-<?= $cardTheme ?>-500 h-full rounded-full transition-all duration-500" style="width: <?= $row['nilai_akhir'] ?>%"></div>
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Rata-rata Akhir</span>
                                    <span class="text-lg font-black text-slate-800"><?= number_format($row['nilai_akhir'], 1) ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full bg-white p-12 md:p-20 rounded-[2.5rem] text-center border-2 border-dashed border-slate-200">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-3xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-500 font-bold text-lg">Data tidak ditemukan.</p>
                            <p class="text-slate-400 text-sm mb-6">Coba gunakan filter lain atau reset pencarian.</p>
                            <a href="daftar_nilai.php" class="inline-flex bg-slate-100 text-slate-600 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Lihat Semua Data</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('sidebar-open');
        }
    </script>
</body>
</html>