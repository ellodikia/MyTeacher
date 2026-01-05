<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter_kelas = isset($_GET['kelas']) ? mysqli_real_escape_string($conn, $_GET['kelas']) : '';

$list_kelas = mysqli_query($conn, "SELECT DISTINCT kelas_jurusan FROM daftar_siswa ORDER BY kelas_jurusan ASC");

$query_sql = "SELECT * FROM daftar_siswa WHERE 1=1";

if ($search != '') {
    $query_sql .= " AND (nama_siswa LIKE '%$search%' OR nisn LIKE '%$search%')";
}
if ($filter_kelas != '') {
    $query_sql .= " AND kelas_jurusan = '$filter_kelas'";
}

$query_sql .= " ORDER BY id_siswa DESC";
$data_siswa = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <title>Data Siswa - MYTEACHER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex flex-col lg:flex-row min-h-screen">

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
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Database Siswa</h1>
                        <p class="text-slate-500 font-medium mt-1">Total <span class="text-blue-600 font-bold"><?= mysqli_num_rows($data_siswa) ?></span> siswa terdaftar di sistem.</p>
                    </div>
                    <a href="tambah_data_siswa.php" class="inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-black shadow-xl shadow-blue-200 transition-all active:scale-95 text-sm uppercase tracking-wider">
                        <i class="fas fa-plus-circle"></i> Tambah Siswa
                    </a>
                </div>

                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-200 mb-10">
                    <form method="GET" class="flex flex-col lg:flex-row gap-4">
                        <div class="flex-1 relative group">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="search" value="<?= $search ?>" placeholder="Cari nama atau nomor induk..." 
                                   class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none font-bold text-slate-700 transition-all placeholder:text-slate-300">
                        </div>
                        <div class="w-full lg:w-64">
                            <select name="kelas" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none font-bold text-slate-700 appearance-none cursor-pointer">
                                <option value="">Semua Kelas</option>
                                <?php mysqli_data_seek($list_kelas, 0); while($k = mysqli_fetch_assoc($list_kelas)): ?>
                                    <option value="<?= $k['kelas_jurusan'] ?>" <?= $filter_kelas == $k['kelas_jurusan'] ? 'selected' : '' ?>><?= $k['kelas_jurusan'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 lg:flex-none bg-slate-900 text-white px-10 py-4 rounded-2xl font-black hover:bg-blue-600 transition-all shadow-lg shadow-slate-100 uppercase text-xs tracking-widest">
                                Cari
                            </button>
                            <?php if($search != '' || $filter_kelas != ''): ?>
                                <a href="data_siswa.php" class="flex items-center justify-center w-14 bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all border border-rose-100 shadow-sm" title="Reset Filter">
                                    <i class="fas fa-undo-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php if(mysqli_num_rows($data_siswa) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($data_siswa)): ?>
                        <div class="bg-white rounded-[2.5rem] border border-slate-200 p-6 hover:border-blue-400 hover:shadow-2xl hover:shadow-blue-100/50 transition-all duration-300 group relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full group-hover:bg-blue-50 transition-colors duration-300"></div>
                            
                            <div class="relative flex items-start gap-5">
                                <div class="w-16 h-16 shrink-0 rounded-[1.5rem] bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center font-black text-2xl shadow-lg shadow-blue-100">
                                    <?= strtoupper(substr($row['nama_siswa'], 0, 1)) ?>
                                </div>
                                
                                <div class="flex-1 min-w-0 pt-1">
                                    <h3 class="font-black text-slate-800 text-lg leading-tight truncate pr-4 group-hover:text-blue-600 transition-colors uppercase">
                                        <?= $row['nama_siswa'] ?>
                                    </h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-lg">
                                            NISN: <?= $row['nisn'] ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-tighter">Kelas & Jurusan</span>
                                    <span class="text-sm font-bold text-slate-600 uppercase italic">
                                        <i class="fas fa-layer-group text-blue-400 mr-1 text-xs"></i> <?= $row['kelas_jurusan'] ?>
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <a href="edit_data_siswa.php?id=<?= $row['id_siswa'] ?>" 
                                       class="w-11 h-11 flex items-center justify-center rounded-2xl bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all shadow-sm" title="Edit Biodata">
                                        <i class="fas fa-pencil-alt text-sm"></i>
                                    </a>
                                    <a href="hapus_data_siswa.php?id=<?= $row['id_siswa'] ?>" 
                                       onclick="return confirm('Hapus data siswa ini?')"
                                       class="w-11 h-11 flex items-center justify-center rounded-2xl bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Hapus Permanen">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full py-20 bg-white rounded-[3rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-search text-4xl text-slate-200"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-800">Siswa tidak ditemukan</h3>
                            <p class="text-slate-400 mt-2 font-medium px-6">Coba gunakan kata kunci lain atau periksa filter kelas Anda.</p>
                            <a href="data_siswa.php" class="mt-6 text-blue-600 font-bold hover:underline">Tampilkan semua siswa</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-12 text-center">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">End of database</p>
                </div>

            </div>
        </main>
    </div>

    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>