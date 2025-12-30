<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    // Mengamankan input teks
    $nama_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $kelas_jurusan = mysqli_real_escape_string($koneksi, $_POST['kelas_jurusan']);
    $mata_pelajaran = mysqli_real_escape_string($koneksi, $_POST['mata_pelajaran']);
    
    // Mengambil nilai angka
    $nilai_harian = $_POST['nilai_harian']; // Hasil rata-rata dari JS
    $nilai_uh = $_POST['nilai_uh'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];

    $query = "INSERT INTO daftar_nilai (nama_siswa, kelas_jurusan, mata_pelajaran, nilai_harian, nilai_uh, nilai_uts, nilai_uas) 
              VALUES ('$nama_siswa', '$kelas_jurusan', '$mata_pelajaran', '$nilai_harian', '$nilai_uh', '$nilai_uts', '$nilai_uas')";
    
    if(mysqli_query($koneksi, $query)){
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
    <title>Tambah Nilai Rapor</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .form-group { margin-bottom: 15px; }
        .box-tugas { border: 1px solid #ddd; padding: 15px; background: #f9f9f9; border-radius: 5px; }
        .item-tugas { margin-bottom: 5px; display: flex; gap: 10px; }
        input[type="text"], input[type="number"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 15px; cursor: pointer; }
        .btn-simpan { background-color: #28a745; color: white; border: none; padding: 10px 20px; font-size: 16px; }
    </style>
</head>
<body>
    <h2>Tambah Data Nilai Siswa</h2>
    <a href="daftar_nilai.php">« Kembali ke Daftar</a><br><br>

    <form action="" method="post">
        <div class="form-group">
            <input type="text" name="nama_siswa" placeholder="Nama Lengkap Siswa" style="width: 300px;" required>
        </div>
        <div class="form-group">
            <input type="text" name="kelas_jurusan" placeholder="Kelas / Jurusan" required>
            <input type="text" name="mata_pelajaran" placeholder="Mata Pelajaran" required>
        </div>

        <div class="box-tugas">
            <label><strong>Input Nilai Tugas/Harian (Fleksibel):</strong></label><br><br>
            <div id="list-input-tugas">
                <div class="item-tugas">
                    <input type="number" class="input-skor" placeholder="Nilai 1" step="0.1" min="0" max="100" oninput="hitungRataRata()">
                    <button type="button" onclick="hapusTugas(this)">Hapus</button>
                </div>
            </div>
            <br>
            <button type="button" onclick="tambahTugas()">+ Tambah Baris Tugas</button>
            <hr>
            <label>Hasil Rata-rata Harian (Otomatis):</label>
            <input type="number" name="nilai_harian" id="hasil_harian" step="0.1" readonly required style="background:#eee; font-weight:bold;">
        </div>

        <br>
        <div class="form-group">
            <label>Nilai UH:</label> <input type="number" name="nilai_uh" step="0.1" min="0" max="100" required>
            <label>Nilai UTS:</label> <input type="number" name="nilai_uts" step="0.1" min="0" max="100" required>
            <label>Nilai UAS:</label> <input type="number" name="nilai_uas" step="0.1" min="0" max="100" required>
        </div>

        <button type="submit" name="simpan" class="btn-simpan">Simpan ke Database</button>
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
        const rata = count > 0 ? (total / count) : 0;
        document.getElementById('hasil_harian').value = rata.toFixed(1);
    }
    </script>
</body>
</html>