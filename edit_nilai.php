<?php
include 'koneksi.php';

// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data lama untuk ditampilkan di form
$query_ambil = mysqli_query($koneksi, "SELECT * FROM daftar_nilai WHERE id=$id");
$d = mysqli_fetch_assoc($query_ambil);

// Jika data tidak ditemukan
if (!$d) {
    die("Data tidak ditemukan!");
}

if(isset($_POST['update'])) {
    $nama_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $kelas_jurusan = mysqli_real_escape_string($koneksi, $_POST['kelas_jurusan']);
    $mata_pelajaran = mysqli_real_escape_string($koneksi, $_POST['mata_pelajaran']);
    $nilai_harian = $_POST['nilai_harian'];
    $nilai_uh = $_POST['nilai_uh'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];

    // Update data berdasarkan ID
    $query_update = "UPDATE daftar_nilai SET 
                    nama_siswa='$nama_siswa', 
                    kelas_jurusan='$kelas_jurusan', 
                    mata_pelajaran='$mata_pelajaran',
                    nilai_harian='$nilai_harian', 
                    nilai_uh='$nilai_uh', 
                    nilai_uts='$nilai_uts', 
                    nilai_uas='$nilai_uas'
                    WHERE id=$id";
    
    if(mysqli_query($koneksi, $query_update)) {
        header("Location: daftar_nilai.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai Siswa</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .form-group { margin-bottom: 15px; }
        .box-tugas { border: 1px solid #ddd; padding: 15px; background: #f9f9f9; border-radius: 5px; }
        .item-tugas { margin-bottom: 5px; display: flex; gap: 10px; }
        input[type="text"], input[type="number"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 15px; cursor: pointer; }
        .btn-update { background-color: #007bff; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Edit Data Nilai Siswa</h2>
    <a href="daftar_nilai.php">« Kembali ke Daftar</a><br><br>

    <form action="" method="post">
        <div class="form-group">
            <label>Nama Siswa:</label><br>
            <input type="text" name="nama_siswa" value="<?= htmlspecialchars($d['nama_siswa']) ?>" style="width: 300px;" required>
        </div>
        
        <div class="form-group">
            <label>Kelas/Jurusan:</label>
            <input type="text" name="kelas_jurusan" value="<?= htmlspecialchars($d['kelas_jurusan']) ?>" required>
            <label>Mata Pelajaran:</label>
            <input type="text" name="mata_pelajaran" value="<?= htmlspecialchars($d['mata_pelajaran']) ?>" required>
        </div>

        <div class="box-tugas">
            <label><strong>Kalkulator Nilai Harian Baru:</strong></label>
            <p style="font-size: 0.8em; color: gray;">*Masukkan nilai tugas baru di bawah ini untuk memperbarui rata-rata harian.</p>
            <div id="list-input-tugas">
                <div class="item-tugas">
                    <input type="number" class="input-skor" placeholder="Nilai Tugas" step="0.1" min="0" max="100" oninput="hitungRataRata()">
                    <button type="button" onclick="hapusTugas(this)">Hapus</button>
                </div>
            </div>
            <br>
            <button type="button" onclick="tambahTugas()">+ Tambah Baris Tugas</button>
            <hr>
            <label>Nilai Harian Saat Ini (di Database):</label>
            <input type="number" name="nilai_harian" id="hasil_harian" value="<?= $d['nilai_harian'] ?>" step="0.1" readonly required style="background:#eee; font-weight:bold;">
        </div>

        <br>
        <div class="form-group">
            <label>Nilai UH:</label> <input type="number" name="nilai_uh" value="<?= $d['nilai_uh'] ?>" step="0.1" min="0" max="100" required>
            <label>Nilai UTS:</label> <input type="number" name="nilai_uts" value="<?= $d['nilai_uts'] ?>" step="0.1" min="0" max="100" required>
            <label>Nilai UAS:</label> <input type="number" name="nilai_uas" value="<?= $d['nilai_uas'] ?>" step="0.1" min="0" max="100" required>
        </div>

        <button type="submit" name="update" class="btn-update">Update Data</button>
    </form>

    <script>
    function tambahTugas() {
        const container = document.getElementById('list-input-tugas');
        const div = document.createElement('div');
        div.className = 'item-tugas';
        div.innerHTML = `
            <input type="number" class="input-skor" placeholder="Nilai" step="0.1" min="0" max="100" oninput="hitungRataRata()">
            <button type="button" onclick="hapusTugas(this)">Hapus</button>
        `;
        container.appendChild(div);
    }

    function hapusTugas(btn) {
        btn.parentElement.remove();
        hitungRataRata();
    }

    function hitungRataRata() {
        const inputs = document.querySelectorAll('.input-skor');
        let total = 0;
        let count = 0;
        
        inputs.forEach(input => {
            if(input.value !== "") {
                total += parseFloat(input.value);
                count++;
            }
        });

        // Jika ada input baru, gunakan rata-rata baru. 
        // Jika semua input kosong, tetap gunakan nilai lama dari database.
        if (count > 0) {
            const rata = total / count;
            document.getElementById('hasil_harian').value = rata.toFixed(1);
        }
    }
    </script>
</body>
</html>