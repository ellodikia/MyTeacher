<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM daftar_nilai WHERE id=$id");
header("Location: daftar_nilai.php");
