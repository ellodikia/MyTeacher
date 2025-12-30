<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
    
    $cek_foto = mysqli_query($conn, "SELECT foto FROM guru WHERE id = '$id_hapus'");
    if (mysqli_num_rows($cek_foto) > 0) {
        $data_foto = mysqli_fetch_assoc($cek_foto);
        $nama_file = $data_foto['foto'];
        
        if (!empty($nama_file)) {
            $path_file = "uploads/guru/" . $nama_file;
            if (file_exists($path_file)) {
                unlink($path_file);
            }
        }
    }

    $query_hapus = mysqli_query($conn, "DELETE FROM guru WHERE id = '$id_hapus'");
    if ($query_hapus) {
        echo "<script>alert('Data guru dan foto berhasil dihapus!'); window.location='data_pengguna.php';</script>";
        exit;
    }
}

$res_admin = mysqli_query($conn, "SELECT nama_guru, foto FROM guru WHERE id = '1'");
$data_admin = mysqli_fetch_assoc($res_admin);

$query_guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-8">
        <header class="flex flex-col md:flex-row md:justify-between md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Pengguna</h1>
                <p class="text-slate-500">Kelola akun guru dan tenaga pengajar sekolah</p>
            </div>
            <a href="registrasi_guru.php" class="inline-flex items-center justify-center bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all gap-2">
                <i class="fas fa-plus"></i>
                Tambah Guru Baru
            </a>
        </header>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-xs uppercase tracking-[0.15em] font-bold text-slate-400">Informasi Guru</th>
                            <th class="px-8 py-5 text-xs uppercase tracking-[0.15em] font-bold text-slate-400">ID Akun</th>
                            <th class="px-8 py-5 text-xs uppercase tracking-[0.15em] font-bold text-slate-400 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(mysqli_num_rows($query_guru) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($query_guru)): ?>
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-5">
                                        <div class="relative">
                                            <?php 
                                                $path_foto = 'uploads/guru/' . $row['foto'];
                                                $avatar_url = 'https://ui-avatars.com/api/?name=' . urlencode($row['nama_guru']) . '&background=EEF2FF&color=4F46E5&bold=true';
                                                $foto_tampil = (!empty($row['foto']) && file_exists($path_foto)) ? $path_foto : $avatar_url;
                                            ?>
                                            <img src="<?= $foto_tampil ?>" 
                                                 class="w-14 h-14 rounded-2xl object-cover border-2 border-white shadow-md group-hover:scale-105 transition-transform"
                                                 alt="Foto <?= $row['nama_guru'] ?>">
                                            <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-slate-700"><?= htmlspecialchars($row['nama_guru']) ?></p>
                                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Tenaga Pengajar</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="font-mono text-sm bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg border border-slate-200">
                                        USR-<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex justify-center items-center gap-3">
                                        
                                        <a href="data_pengguna.php?hapus=<?= $row['id'] ?>" 
                                           onclick="return confirm('Hapus akun <?= htmlspecialchars($row['nama_guru']) ?>? Tindakan ini tidak dapat dibatalkan.')"
                                           class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" 
                                           title="Hapus Guru">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-users-slash text-3xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700">Tidak ada data ditemukan</h3>
                                        <p class="text-slate-400">Silakan tambahkan guru baru melalui tombol di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-slate-50/50 px-8 py-4 border-t border-slate-100">
                <p class="text-xs text-slate-400 font-medium">Total Terdaftar: <span class="text-slate-700"><?= mysqli_num_rows($query_guru) ?> Guru</span></p>
            </div>
        </div>
    </main>

</body>
</html>