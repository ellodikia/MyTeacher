<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}
include 'koneksi.php';

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
    <title>Manajemen Data Siswa</title>
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
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Master Siswa</h1>
                    <p class="text-slate-500 font-medium">Kelola informasi biodata dan identitas seluruh siswa.</p>
                </div>
                <a href="tambah_data_siswa.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95">
                    <i class="fas fa-user-plus"></i> Tambah Siswa Baru
                </a>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-200 mb-8">
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="search" value="<?= $search ?>" placeholder="Cari berdasarkan Nama atau NISN..." 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-medium">
                    </div>
                    <div class="w-full md:w-64">
                        <select name="kelas" class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-semibold text-slate-700">
                            <option value="">Semua Kelas</option>
                            <?php while($k = mysqli_fetch_assoc($list_kelas)): ?>
                                <option value="<?= $k['kelas_jurusan'] ?>" <?= $filter_kelas == $k['kelas_jurusan'] ? 'selected' : '' ?>><?= $k['kelas_jurusan'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-900 transition-all">
                        Filter
                    </button>
                    <?php if($search != '' || $filter_kelas != ''): ?>
                        <a href="data_siswa.php" class="flex items-center justify-center p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all" title="Reset">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-slate-400">
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Siswa</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Identitas (NISN)</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Kelas & Jurusan</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(mysqli_num_rows($data_siswa) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($data_siswa)): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                                <?= substr($row['nama_siswa'], 0, 1) ?>
                                            </div>
                                            <span class="font-bold text-slate-700"><?= $row['nama_siswa'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold tracking-wider">
                                            <?= $row['nisn'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-500 font-medium"><?= $row['kelas_jurusan'] ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="edit_data_siswa.php?id=<?= $row['id_siswa'] ?>" 
                                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 hover:bg-yellow-500 hover:text-white transition-all shadow-sm" title="Edit Data">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <a href="hapus_data_siswa.php?id=<?= $row['id_siswa'] ?>" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Semua nilai terkait juga mungkin akan terpengaruh.')"
                                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Hapus Data">
                                                <i class="fas fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-user-slash text-4xl text-slate-200 mb-4"></i>
                                            <p class="text-slate-400 font-bold">Tidak ada data siswa ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex justify-between items-center px-4">
                <p class="text-sm text-slate-400">Total: <span class="font-bold text-slate-700"><?= mysqli_num_rows($data_siswa) ?></span> Siswa terdaftar</p>
            </div>

        </div>
    </main>
</div>

</body>
</html>