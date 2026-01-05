<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Sistem - MYTEACHER</title>
    <link rel="icon" type="image/jpeg" href="img/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .video-container {
            position: relative;
            padding-bottom: 56.25%; 
            height: 0;
            overflow: hidden;
        }
        .video-container iframe, .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 1.5rem;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">

    <nav class="p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2 group">
                <div class="bg-white p-2 rounded-xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <span class="font-bold text-slate-600">Kembali ke Beranda</span>
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pb-20">
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-black text-slate-900 mb-4">Eksplorasi Sistem</h1>
            <p class="text-slate-500 max-w-2xl mx-auto font-medium">Lihat bagaimana MY-TEACHER membantu mempermudah manajemen nilai dan data siswa dalam satu platform terintegrasi.</p>
        </div>

        <section class="mb-20">
            <div class="bg-white p-4 rounded-[2.5rem] shadow-2xl shadow-blue-500/5 border border-slate-100">
                <div class="video-container">
                    <video controls poster="">
                        <source src="img/2.mp4" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-2">Video Tur Dashboard</h2>
                    <p class="text-slate-500">Video ini menjelaskan alur kerja dari input nilai hingga hasil akhir raport otomatis.</p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="group">
                <div class="overflow-hidden rounded-3xl mb-4 border-4 border-white shadow-lg">
                    <img src="img/dashboard.png" 
                         alt="Dashboard Admin" class="w-full h-64 object-cover transform group-hover:scale-110 transition-duration-500">
                </div>
                <h3 class="text-lg font-bold px-2">Dashboard Admin</h3>
            </div>

            <div class="group">
                <div class="overflow-hidden rounded-3xl mb-4 border-4 border-white shadow-lg">
                    <img src="img/daftarnilaii.png" 
                         alt="Input Nilai" class="w-full h-64 object-cover transform group-hover:scale-110 transition-duration-500">
                </div>
                <h3 class="text-lg font-bold px-2">Input Nilai</h3>
            </div>

            <div class="group">
                <div class="overflow-hidden rounded-3xl mb-4 border-4 border-white shadow-lg">
                    <img src="img/daftarranking.png" 
                         alt="Ranking Page" class="w-full h-64 object-cover transform group-hover:scale-110 transition-duration-500">
                </div>
                <h3 class="text-lg font-bold px-2">Sistem Ranking</h3>
            </div>

        </div>

        <div class="mt-20 text-center bg-slate-900 rounded-[3rem] py-16 px-6">
            <h2 class="text-3xl font-bold text-white mb-6">Siap Untuk Memulai?</h2>
            <a href="login.php" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-blue-700 transition-all inline-block">
                LOGIN KE DASHBOARD
            </a>
        </div>
    </main>

</body>
</html>