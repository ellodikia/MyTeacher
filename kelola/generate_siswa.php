<?php
include 'koneksi.php';

$nama_depan = ["Budi", "Siti", "Ahmad", "Dewi", "Eko", "Fitri", "Guntur", "Hani", "Iwan", "Joko", "Lestari", "Rendi", "Pratama", "Putri", "Zaki"];
$nama_belakang = ["Santoso", "Aminah", "Fauzi", "Lestari", "Prasetyo", "Wibowo", "Saputri", "Widodo", "Kurniawan", "Sari", "Utami", "Hidayat"];

$tingkat = ["X", "XI", "XII"];
$jurusan = ["RPL", "DKV", "PH", "OTKP", "AKL"];

echo "Memulai proses input daftar siswa...<br>";

$counter = 1;
foreach ($tingkat as $t) {
    foreach ($jurusan as $j) {
        $kelas_jurusan = "$t $j";
        
        for ($i = 1; $i <= 10; $i++) {
            $nama_lengkap = $nama_depan[array_rand($nama_depan)] . " " . $nama_belakang[array_rand($nama_belakang)];
            
            $nisn = 1000 + $counter;
            $alamat = "Jl. Contoh No. " . $counter;

            $sql = "INSERT INTO daftar_siswa (nama_siswa, nisn, kelas_jurusan, alamat) 
                    VALUES ('$nama_lengkap', '$nisn', '$kelas_jurusan', '$alamat')";
            
            mysqli_query($conn, $sql);
            $counter++;
        }
    }
}

echo "Berhasil! " . ($counter - 1) . " data siswa telah dimasukkan ke database.";
?>