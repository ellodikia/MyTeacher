<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'admin') {
   header("Location: ../login.php");
    exit;
}

include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama_guru = mysqli_real_escape_string($conn, $_POST['nama_guru']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = mysqli_real_escape_string($conn, $_POST['level']); 
    
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $foto_baru = "";

    if (!empty($foto)) {
        $ekstensi = pathinfo($foto, PATHINFO_EXTENSION);
        $foto_baru = date('dmYHis') . "_" . uniqid() . "." . $ekstensi;
        $path = "uploads/guru/" . $foto_baru;
        
        if (!is_dir("uploads/guru/")) {
            mkdir("uploads/guru/", 0777, true);
        }
        move_uploaded_file($tmp, $path);
    }

    $query = "INSERT INTO guru (nama_guru, password, foto, level) VALUES ('$nama_guru', '$password', '$foto_baru', '$level')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengguna berhasil didaftarkan sebagai $level!'); window.location='data_pengguna.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal mendaftar: " . mysqli_error($conn) . "');</script>";
    }
}

$id_admin = $_SESSION['id_user']; 
$res_admin = mysqli_query($conn, "SELECT nama_guru, foto FROM guru WHERE id = '$id_admin'");
$data_admin = mysqli_fetch_assoc($res_admin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #loading-overlay { display: none; }
        .processing { pointer-events: none; opacity: 0.7; }
    </style>
</head>
<body class="bg-slate-50 flex">

    <div id="loading-overlay" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-900/60 backdrop-blur-sm">
        <div class="relative flex items-center justify-center">
            <div class="w-20 h-20 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
            <i class="fas fa-user-shield text-white absolute animate-pulse"></i>
        </div>
        <p class="mt-4 text-white font-bold tracking-wider uppercase">Menyimpan Akun...</p>
    </div>

    <?php include 'sidebar.php'; ?>

    <main id="main-content" class="flex-1 p-8">
        <header class="mb-10">
            <h1 class="text-2xl font-bold text-slate-800">Registrasi Pengguna Baru</h1>
            <p class="text-slate-500">Tentukan level akses untuk akun baru</p>
        </header>

        <div class="max-w-2xl bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="return handleForm(this)">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_guru" required placeholder="Nama Pengguna"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Hak Akses (Level)</label>
                        <select name="level" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white">
                            <option value="guru">Guru (Pengajar)</option>
                            <option value="admin">Admin (Administrator)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password Akun</label>
                    <input type="password" name="password" required placeholder="********"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Foto Profil</label>
                    <div class="relative group">
                        <input id="file-upload" name="foto" type="file" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <label for="file-upload" 
                               class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-indigo-300 rounded-2xl bg-indigo-50/30 cursor-pointer transition-all duration-300 group-hover:bg-indigo-50 group-hover:border-indigo-500">
                            
                            <div id="placeholder-content" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-camera text-3xl text-indigo-600 mb-2"></i>
                                <p class="text-sm font-bold text-indigo-700">Unggah Foto Profil</p>
                            </div>

                            <div id="image-preview-container" class="hidden absolute inset-0 w-full h-full p-2">
                                <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover rounded-xl shadow-inner">
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="submit" id="btn-submit"
                            class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                        <i class="fas fa-check-circle"></i>
                        Daftarkan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(input) {
            const container = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('placeholder-content');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                    placeholder.classList.add('invisible');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleForm(form) {
            document.getElementById('loading-overlay').style.display = 'flex';
            document.getElementById('main-content').classList.add('processing');
            document.getElementById('btn-submit').disabled = true;
            return true;
        }
    </script>
</body>
</html>