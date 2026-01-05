<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'admin') { header("Location: ../login.php"); exit; }
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
    $cek = mysqli_query($conn, "SELECT foto FROM guru WHERE id = '$id_hapus'");
    $data_f = mysqli_fetch_assoc($cek);
    if (!empty($data_f['foto']) && file_exists("../uploads/guru/".$data_f['foto'])) {
        unlink("../uploads/guru/".$data_f['foto']);
    }
    mysqli_query($conn, "DELETE FROM guru WHERE id = '$id_hapus'");
    header("Location: data_pengguna.php");
}

$query_guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Guru - MYTEACHER</title>
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex flex-col md:flex-row min-h-screen">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-4 md:p-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                <h2 class="text-lg font-bold text-slate-800 uppercase italic">Data Guru</h2>
                <a href="registrasi_guru.php" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-xs hover:bg-indigo-700 transition-all uppercase italic">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">ID / Hak Akses</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php while($row = mysqli_fetch_assoc($query_guru)): ?>
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= !empty($row['foto']) ? '../uploads/guru/'.$row['foto'] : 'https://ui-avatars.com/api/?name='.urlencode($row['nama_guru']) ?>" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                    <span class="font-bold text-slate-700 text-sm italic"><?= $row['nama_guru'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs text-slate-400">ID: #<?= $row['id'] ?></span>
                                    <span class="text-[10px] font-bold uppercase text-indigo-600"><?= $row['level'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                    <i class="fas fa-trash-can text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>