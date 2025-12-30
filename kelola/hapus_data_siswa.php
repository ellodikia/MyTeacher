<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM daftar_siswa WHERE id_siswa = $id");

if($query) {
    header("Location: data_siswa.php");
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
?>