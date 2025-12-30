<?php
$data_admin = [
    'nama_guru' => 'Administrator Utama',
    'foto'      => '' 
];

$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="flex flex-col w-64 h-screen px-4 py-8 bg-slate-900 border-r border-slate-800 sticky top-0 overflow-y-auto shrink-0 transition-all">
    <a href="index.php" class="flex items-center gap-3 px-2 mb-8 text-white no-underline">
        <div class="p-2 bg-indigo-600 rounded-lg shadow-lg shadow-indigo-900/20">
            <i class="fas fa-user-shield text-xl"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-xl font-bold tracking-tight leading-none">Admin Panel</span>
            <span class="text-[10px] text-slate-500 font-medium uppercase tracking-wider mt-1">Sistem Management</span>
        </div>
    </a>

    <div class="flex flex-col justify-between flex-1">
        <nav class="space-y-2">
            
            <a href="index.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'index.php') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-chart-pie <?= ($current_page == 'index.php') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400'; ?>"></i>
                <span class="font-medium">Dashboard Admin</span>
            </a>

            <a href="registrasi_guru.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'registrasi_guru.php') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-user-plus <?= ($current_page == 'registrasi_guru.php') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400'; ?>"></i>
                <span class="font-medium">Registrasi Guru</span>
            </a>

            <a href="data_pengguna.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'data_pengguna.php') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-users-cog <?= ($current_page == 'data_pengguna.php') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400'; ?>"></i>
                <span class="font-medium">Kelola User</span>
            </a>

        </nav>

        <div class="pt-6 mt-6 border-t border-slate-800">
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 px-2">
                    <?php 
                        $foto_path = !empty($data_admin['foto']) ? 'uploads/admin/'.$data_admin['foto'] : 'https://ui-avatars.com/api/?name='.urlencode($data_admin['nama_guru']).'&background=4f46e5&color=fff';
                    ?>
                    <div class="relative">
                        <img src="<?= $foto_path ?>" 
                             alt="Avatar" class="w-10 h-10 rounded-full border-2 border-slate-700 object-cover">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-slate-900 rounded-full"></span>
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold text-white truncate"><?= $data_admin['nama_guru'] ?></span>
                        <span class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Administrator</span>
                    </div>
                </div>

                <a href="../logout.php" 
                   onclick="return confirm('Apakah Anda yakin ingin keluar dari panel admin?')"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                    <i class="fas fa-power-off"></i>
                    <span class="font-medium">Sign Out</span>
                </a>
            </div>
        </div>
    </div>
</div>