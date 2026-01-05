<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

$id_session = $_SESSION['id_guru'] ?? 0;

$query_side = mysqli_query($conn, "SELECT nama_guru, foto FROM guru WHERE id = '$id_session'");
$data_side = mysqli_fetch_assoc($query_side);

$nama_user = $data_side['nama_guru'] ?? 'Admin';
$level_user = $_SESSION['level'] ?? 'Guest';

if (!empty($data_side['foto']) && file_exists("../uploads/guru/" . $data_side['foto'])) {
    $foto_user = "../uploads/guru/" . $data_side['foto'];
} else {
    $foto_user = "https://ui-avatars.com/api/?name=" . urlencode($nama_user) . "&background=4f46e5&color=fff&bold=true";
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="md:hidden bg-slate-900 text-white p-4 flex justify-between items-center sticky top-0 z-[60] shadow-xl">
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-graduation-cap text-white text-sm"></i>
        </div>
        <span class="font-bold uppercase tracking-widest text-xs italic">E-Raport Admin</span>
    </div>
    <button onclick="document.getElementById('sidebar-container').classList.toggle('-translate-x-full')" class="text-xl p-2 hover:bg-slate-800 rounded-lg transition-all">
        <i class="fas fa-bars"></i>
    </button>
</div>

<div id="sidebar-container" class="fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-300 ease-in-out z-50 flex flex-col w-64 h-screen px-4 py-8 bg-slate-900 border-r border-slate-800 shrink-0 shadow-2xl md:shadow-none">
    
    <div class="flex items-center gap-3 px-2 mb-10">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
            <i class="fas fa-graduation-cap text-white text-xl"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-white font-bold leading-none italic uppercase tracking-tight">Admin Panel</span>
            <span class="text-slate-500 text-[10px] uppercase font-black tracking-widest">Sistem Management</span>
        </div>
    </div>

    <nav class="flex-1 flex flex-col gap-2">
        <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= $current_page == 'index.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-th-large w-5"></i>
            <span class="text-sm font-bold uppercase italic tracking-wide">Dashboard</span>
        </a>
        
        <a href="registrasi_guru.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= $current_page == 'registrasi_guru.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-user-plus w-5"></i>
            <span class="text-sm font-bold uppercase italic tracking-wide">Registrasi</span>
        </a>

        <a href="data_pengguna.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= $current_page == 'data_pengguna.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/40' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-users-gear w-5"></i>
            <span class="text-sm font-bold uppercase italic tracking-wide">Kelola Guru</span>
        </a>
    </nav>

    <div class="pt-6 mt-6 border-t border-slate-800">
        <div class="flex items-center gap-3 px-2 mb-6 group cursor-default">
            <div class="relative shrink-0">
                <img src="<?= $foto_user ?>" 
                     class="w-11 h-11 rounded-full border-2 border-indigo-500/30 object-cover bg-slate-800 shadow-inner group-hover:border-indigo-500 transition-all"
                     alt="Profile">
                <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-slate-900 rounded-full shadow-sm"></span>
            </div>
            <div class="flex flex-col overflow-hidden">
                <span class="text-sm font-bold text-white truncate italic tracking-tight" title="<?= htmlspecialchars($nama_user) ?>">
                    <?= htmlspecialchars($nama_user) ?>
                </span>
                <span class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em]">
                    <?= strtoupper($level_user) ?>
                </span>
            </div>
        </div>

        <a href="../logout.php" 
           onclick="return confirm('Apakah Anda yakin ingin keluar?')" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all duration-200 group">
            <i class="fas fa-right-from-bracket w-5 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-sm font-bold uppercase italic tracking-widest">Logout</span>
        </a>
    </div>
</div>

<div onclick="document.getElementById('sidebar-container').classList.add('-translate-x-full')" 
     id="sidebar-overlay"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 md:hidden hidden opacity-0 transition-opacity duration-300">
</div>

<script>
    const sidebar = document.getElementById('sidebar-container');
    const overlay = document.getElementById('sidebar-overlay');

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === "class") {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (!isHidden) {
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.add('opacity-100'), 10);
                } else {
                    overlay.classList.remove('opacity-100');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }
            }
        });
    });

    observer.observe(sidebar, { attributes: true });
</script>