<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_dashboard_guru";
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$pesan = "";

if (isset($_POST['submit'])) {
    $nama_guru = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $level     = $_POST['level'];
    
    $password_input = $_POST['password'];
    $password_hashed = password_hash($password_input, PASSWORD_DEFAULT);
    
    $foto_nama = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    $target_dir = "uploads/guru";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($foto_tmp, $target_dir . $foto_nama)) {
        $query = "INSERT INTO guru (nama_guru, password, level, foto) 
                  VALUES ('$nama_guru', '$password_hashed', '$level', '$foto_nama')";
        
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<div style='color: green; font-weight: bold;'>Akun berhasil dibuat dengan password ter-hash!</div>";
        } else {
            $pesan = "<div style='color: red;'>Gagal query: " . mysqli_error($koneksi) . "</div>";
        }
    } else {
        $pesan = "<div style='color: red;'>Gagal mengunggah foto. Pastikan folder 'uploads' dapat ditulis.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Guru - Fixed</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 25px; border-radius: 10px; width: 350px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 10px; font-size: 14px; color: #666; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; margin-top: 20px; font-size: 16px; }
        .pesan { margin-bottom: 15px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Buat Akun Guru</h2>
    <div class="pesan"><?php echo $pesan; ?></div>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_guru" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Hak Akses</label>
        <select name="level">
            <option value="guru">Guru</option>
            <option value="admin">Admin</option>
        </select>

        <label>Foto Profil</label>
        <input type="file" name="foto" accept="image/*" required>

        <button type="submit" name="submit">Daftarkan Sekarang</button>
    </form>
</div>

</body>
</html>