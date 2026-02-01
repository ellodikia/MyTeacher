##🎓 MYTEACHER - Dashboard Manajemen Guru & Siswa

[![PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892bf.svg)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Framework](https://img.shields.io/badge/UI-Tailwind_CSS-38bdf8.svg)](https://tailwindcss.com/)

**MYTEACHER** adalah solusi sistem informasi akademik berbasis web yang dirancang untuk membantu efisiensi kerja guru. Mulai dari pendataan siswa, pengelolaan nilai mata pelajaran, hingga otomatisasi kalkulasi ranking dan raport digital.

---

## ✨ Fitur Utama

### 🔐 Multi-User Authentication
Sistem membedakan hak akses secara otomatis antara **Admin** dan **Guru**:
* **Admin:** Mengelola kredensial guru, pendaftaran akun baru, dan monitoring statistik global.
* **Guru:** Mengelola data siswa per kelas, menginput nilai harian/ujian, dan melihat ranking siswa.

### 📊 Manajemen Akademik
* **Data Siswa:** CRUD (Create, Read, Update, Delete) informasi siswa lengkap dengan filter kelas.
* **Pengolahan Nilai:** Form input nilai yang mencakup Harian, UH, UTS, dan UAS.
* **Ranking Otomatis:** Algoritma yang menghitung rata-rata nilai akhir secara *real-time* untuk menentukan posisi ranking siswa di tiap kelas.
* **Data Generator:** Tersedia script `generate_siswa.php` dan `generate_nilai.php` untuk mempermudah pengujian sistem dengan ribuan data dummy.

### 🎨 User Interface Modern
* **Responsive Design:** Dibangun menggunakan Tailwind CSS agar nyaman diakses melalui smartphone maupun desktop.
* **Interactive Sidebar:** Navigasi yang intuitif dengan profil pengguna yang dinamis.

---

## 🛠️ Stack Teknologi
* **Backend:** PHP (Native)
* **Database:** MySQL / MariaDB
* **Frontend:** Tailwind CSS, Font Awesome 6
* **Library:** Google Fonts (Plus Jakarta Sans), UI Avatars API

---

## ⚙️ Instalasi

1. **Clone repositori ini:**
   ```bash
   git clone [https://github.com/username/myteacher.git](https://github.com/username/myteacher.git)
