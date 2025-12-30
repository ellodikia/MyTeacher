<?php
include 'koneksi.php';

$query = "SELECT *, 
          ((nilai_harian + nilai_uh + nilai_uts + nilai_uas) / 4) AS nilai_akhir 
          FROM daftar_nilai";
$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Nilai Rapor</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        .rata-rata { font-weight: bold; color: blue; }
    </style>
</head>
<body>
    <h2>Daftar Nilai Siswa</h2>
    <a href="tambah_daftar_nilai.php" style="padding: 10px; background: blue; color: white; text-decoration: none; border-radius: 5px;">+ Tambah Data</a>
    
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas/Jurusan</th>
                <th>Mata Pelajaran</th>
                <th>Harian (Avg)</th>
                <th>UH</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>NILAI AKHIR</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td style="text-align: left;"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                <td><?= htmlspecialchars($row['kelas_jurusan']) ?></td>
                <td><?= htmlspecialchars($row['mata_pelajaran']) ?></td>
                <td><?= number_format($row['nilai_harian'], 1) ?></td>
                <td><?= number_format($row['nilai_uh'], 1) ?></td>
                <td><?= number_format($row['nilai_uts'], 1) ?></td>
                <td><?= number_format($row['nilai_uas'], 1) ?></td>
                <td class="rata-rata"><?= number_format($row['nilai_akhir'], 1) ?></td>
                <td>
                    <a href="edit_nilai.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="hapus_nilai.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>