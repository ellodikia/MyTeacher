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
        $ekstensi = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'ico', 'svg'];

        if (in_array($ekstensi, $allowed)) {
            $foto_baru = date('dmYHis') . "_" . uniqid() . "." . $ekstensi;
            
            $target_path = "../uploads/guru/" . $foto_baru;

            if (!move_uploaded_file($tmp, $target_path)) {
                echo "<script>alert('Gagal mengupload gambar. Pastikan folder uploads/guru tersedia!');</script>";
                $foto_baru = ""; 
            }
        } else {
            echo "<script>alert('Format file tidak didukung! Gunakan jenis gambar umum.');</script>";
        }
    }

    $query = "INSERT INTO guru (nama_guru, password, foto, level) VALUES ('$nama_guru', '$password', '$foto_baru', '$level')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil mendaftarkan guru!'); window.location='data_pengguna.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Guru - MYTEACHER</title>
    <link rel="icon" type="image/jpeg" href="../img/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex flex-col md:flex-row min-h-screen">
    <?php include 'sidebar.php'; ?>
    
    <main class="flex-1 p-4 md:p-8 flex justify-center items-start">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-sm border border-slate-200 p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-6 uppercase italic">Registrasi Guru Baru</h2>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_guru" required placeholder="Masukkan nama lengkap..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-bold italic">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-bold italic">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Level Akses</label>
                    <select name="level" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-bold italic appearance-none">
                        <option value="guru">GURU</option>
                        <option value="admin">ADMINISTRATOR</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Foto Profil (Semua Jenis Gambar)</label>
                    <div class="relative group">
                        <input type="file" name="foto" accept="image/*" 
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-dashed border-slate-300 p-4 rounded-xl">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition-all uppercase italic tracking-widest shadow-lg shadow-indigo-600/20 active:scale-95">
                        <i class="fas fa-save mr-2"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>