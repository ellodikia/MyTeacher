<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="flex flex-col w-64 h-screen px-4 py-8 bg-slate-900 border-r border-slate-800 sticky top-0 overflow-y-auto shrink-0 transition-all">
    <a href="index.php" class="flex items-center gap-3 px-2 mb-8 text-white no-underline">
        <div class="p-2 bg-blue-600 rounded-lg">
            <i class="fas fa-code-branch text-xl"></i>
        </div>
        <span class="text-xl font-bold tracking-tight">My Admin</span>
    </a>

    <div class="flex flex-col justify-between flex-1">
        <nav class="space-y-2">
            <a href="index.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'index.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-home <?= ($current_page == 'index.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <?php 
                $halaman_nilai = ['daftar_nilai.php', 'edit_nilai.php', 'tambah_daftar_nilai.php'];
                $is_nilai_active = in_array($current_page, $halaman_nilai);
            ?>
            <a href="data_siswa.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'data_siswa.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fa-solid fa-graduation-cap <?= ($current_page == 'data_siswa.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Data Siswa</span>
            </a>
            
            <a href="daftar_nilai.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= $is_nilai_active ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fa-solid fa-list <?= $is_nilai_active ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Daftar Nilai</span>
            </a>


            <a href="settings.php" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group 
               <?= ($current_page == 'settings.php') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-cog <?= ($current_page == 'settings.php') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400'; ?>"></i>
                <span class="font-medium">Pengaturan</span>
            </a>
        </nav>

        <div class="pt-6 mt-6 border-t border-slate-800">
            <div class="flex items-center justify-between px-2 text-white">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff" 
                         alt="Avatar" class="w-10 h-10 rounded-full border-2 border-slate-700">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold leading-none">Admin User</span>
                        <span class="text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Administrator</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>