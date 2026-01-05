<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYTEACHER</title>
    <link rel="icon" type="image/jpeg" href="img/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">

    <nav class="fixed w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass-effect py-4 px-8 rounded-3xl shadow-xl shadow-blue-500/5">
            <div class="flex items-center gap-2">
                <span class="font-black text-xl tracking-tight text-slate-800">MY<span class="text-blue-600">TEACHER.</span></span>
            </div>
            <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all transform hover:scale-105 shadow-lg shadow-blue-200">
                Masuk
            </a>
        </div>
    </nav>

    <header class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8 text-center lg:text-left">
                <div class="inline-block px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase tracking-widest">
                    Management System v1.0
                </div>
                <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-tight">
                    Kelola Nilai Siswa <span class="text-blue-600 underline decoration-blue-100">Lebih Cerdas.</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Sistem manajemen nilai terpadu untuk memantau perkembangan akademik, ranking paralel, hingga pengelolaan data siswa secara efisien dan akurat.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="demo.php" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-play-circle"></i> Lihat Demo
                    </a>
                    <a href="#request" class="px-8 py-4 bg-white text-blue-600 border border-blue-100 rounded-2xl font-bold hover:bg-blue-50 transition-all shadow-sm flex items-center justify-center">
                        Minta Akses Admin
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -top-10 -left-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-indigo-400/10 rounded-full blur-3xl"></div>
                <img src="img/dashboard.png" 
                     alt="Dashboard Preview" 
                     class="relative rounded-[2.5rem] shadow-2xl border-8 border-white">
            </div>
        </div>
    </header>

    <section id="demo" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 space-y-4">
                <h2 class="text-4xl font-black text-slate-900">Fitur Unggulan</h2>
                <p class="text-slate-500 font-medium">Antarmuka modern yang memudahkan pekerjaan administratif guru.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-8 rounded-[2.5rem] bg-[#f8fafc] border border-slate-100 hover:border-blue-500 transition-all">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Ranking Otomatis</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Sistem menghitung nilai rata-rata dan menentukan peringkat kelas secara real-time.</p>
                </div>
                <div class="group p-8 rounded-[2.5rem] bg-[#f8fafc] border border-slate-100 hover:border-blue-500 transition-all">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Manajemen Siswa</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Kelola ratusan data siswa dari berbagai jurusan dengan navigasi yang sangat mudah.</p>
                </div>
                <div class="group p-8 rounded-[2.5rem] bg-[#f8fafc] border border-slate-100 hover:border-blue-500 transition-all">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Responsive Design</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Akses dashboard melalui smartphone, tablet, maupun desktop dengan tampilan sempurna.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="request" class="py-20 px-6">
        <div class="max-w-4xl mx-auto bg-blue-600 rounded-[3rem] p-10 lg:p-16 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-200">
            <div class="absolute top-0 right-0 opacity-10 translate-x-10 -translate-y-10">
                <i class="fas fa-envelope text-[15rem]"></i>
            </div>
            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl font-black">Belum memiliki akses login?</h2>
                <p class="text-blue-100 text-lg font-medium opacity-90">
                    Sistem ini bersifat terbatas. Silahkan hubungi administrator melalui email untuk mendapatkan kredensial login dashboard Anda.
                </p>
                <div class="pt-4">
                    <a href="mailto:anosvldg17@gmail.com?subject=Permintaan Akses Login Dashboard&body=Halo Admin, saya ingin meminta akses untuk login ke sistem. Berikut detail identitas saya:" 
                       class="inline-flex items-center gap-3 bg-white text-blue-600 px-10 py-5 rounded-2xl font-black text-lg hover:bg-slate-50 transition-all active:scale-95 shadow-xl">
                        <i class="fas fa-paper-plane"></i> HUBUNGI ADMIN SEKARANG
                    </a>
                </div>
                <p class="text-sm text-blue-200 font-bold">Email: anosvldg17@gmail.com</p>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-2 mb-6">
                <div class="bg-slate-200 p-2 rounded-lg text-slate-600">
                    <i class="fas fa-graduation-cap text-sm"></i>
                </div>
                <span class="font-bold text-slate-800">MY - TEACHER.</span>
            </div>
            <p class="text-slate-400 text-sm">&copy; 2026 ellodikia. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>