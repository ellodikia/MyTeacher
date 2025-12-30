<?php
include 'koneksi.php';

$mapels = [
    'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 
    'Pendidikan Agama', 'PKN', 'Produktif Kejuruan', 
    'Olahraga', 'Seni Budaya', 'Sejarah'
];

$query_siswa = mysqli_query($conn, "SELECT id_siswa FROM daftar_siswa");

echo "Memulai proses input nilai...<br>";

while ($siswa = mysqli_fetch_assoc($query_siswa)) {
    $id_s = $siswa['id_siswa'];

    foreach ($mapels as $m) {
        $harian = rand(70, 95);
        $uh     = rand(70, 95);
        $uts    = rand(70, 95);
        $uas    = rand(70, 95);
        $akhir  = ($harian + $uh + $uts + $uas) / 4;

        $sql = "INSERT INTO daftar_nilai (id_siswa, mata_pelajaran, nilai_harian, nilai_uh, nilai_uts, nilai_uas, nilai_akhir) 
                VALUES ('$id_s', '$m', '$harian', '$uh', '$uts', '$uas', '$akhir')";
        
        mysqli_query($conn, $sql);
    }
}

echo "Berhasil! 1.350 data nilai telah dimasukkan secara otomatis.";
?>