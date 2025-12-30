<?php
// Diasumsikan sudah melakukan koneksi database $conn
// Contoh query untuk mengambil data guru (sesuaikan dengan session ID guru yang login)
// $id_guru = $_SESSION['id_guru']; 
// $query = mysqli_query($conn, "SELECT nama_guru, foto FROM guru WHERE id_guru = '$id_guru'");
// $data_guru = mysqli_fetch_assoc($query);

// Data dummy jika database belum siap (hapus jika sudah pakai query di atas)
$data_guru = [
    'nama_guru' => 'Budi Santoso, S.Pd',
    'foto' => '' 
];

$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="flex flex-col w-64 h-screen px-4 py-8 bg-slate-900 border-r border-slate-800 sticky top-0 overflow-y-auto shrink-0 transition-all">
    <a href="index.php" class="flex items-center gap-3 px-2 mb-8 text-white no-underline">
        <div class="p-2 bg-blue-600 rounded-lg">
            <i class="fas fa-chalkboard-teacher text-xl"></i>
        </div>
        <span class="text-xl font-bold tracking-tight">E-Raport</span>
    </a>

    <div class="flex flex-col justify-between flex-1">
        <nav class="space-y-2">
            <a href="index.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'index.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-home <?= ($current_page == 'index.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="data_siswa.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'data_siswa.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fa-solid fa-graduation-cap <?= ($current_page == 'data_siswa.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Data Siswa</span>
            </a>
            
            <?php 
                $halaman_nilai = ['daftar_nilai.php', 'edit_nilai.php', 'tambah_daftar_nilai.php'];
                $is_nilai_active = in_array($current_page, $halaman_nilai);
            ?>
            <a href="daftar_nilai.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= $is_nilai_active ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fa-solid fa-file-signature <?= $is_nilai_active ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Daftar Nilai</span>
            </a>

            <a href="raport.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'raport.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fa-solid fa-file-invoice <?= ($current_page == 'raport.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Raport</span>
            </a>

            <a href="settings.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'settings.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-cog <?= ($current_page == 'settings.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Pengaturan</span>
            </a>
        </nav>

        <div class="pt-6 mt-6 border-t border-slate-800">
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 px-2">
                    <?php 
                        $foto_profil = !empty($data_guru['foto']) ? 'uploads/guru/'.$data_guru['foto'] : 'https://ui-avatars.com/api/?name='.urlencode($data_guru['nama_guru']).'&background=0D8ABC&color=fff';
                    ?>
                    <img src="<?= $foto_profil ?>" 
                         alt="Avatar" class="w-10 h-10 rounded-full border-2 border-slate-700 object-cover">
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold text-white truncate"><?= $data_guru['nama_guru'] ?></span>
                        <span class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Tenaga Pengajar</span>
                    </div>
                </div>

                <a href="logout.php" 
                   onclick="return confirm('Apakah anda yakin ingin keluar?')"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="font-medium">Keluar</span>
                </a>
            </div>
        </div>
    </div>
</div>