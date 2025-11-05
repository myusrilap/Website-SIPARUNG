<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Pastikan metode POST digunakan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_agenda = mysqli_real_escape_string($koneksi, $_POST['nama_agenda']);
    $nama_ruangan = mysqli_real_escape_string($koneksi, $_POST['nama_ruangan']);
    $tanggal_mulai = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($koneksi, $_POST['tanggal_selesai']);
    $jam_mulai = mysqli_real_escape_string($koneksi, date("H:i", strtotime($_POST['jam_mulai'])));
    $jam_selesai = mysqli_real_escape_string($koneksi, date("H:i", strtotime($_POST['jam_selesai'])));
    $peminjam = mysqli_real_escape_string($koneksi, $_POST['peminjam']);
    $email_user = mysqli_real_escape_string($koneksi, $_SESSION['email']);

    $file = $_FILES['surat_permohonan'];
    $allowed_ext = 'pdf';
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_size_limit = 1048576; // 1MB
    $upload_dir = '../uploads/permohonan/';

    if ($file_ext !== $allowed_ext) {
        header("Location: form.php?error=Hanya file PDF yang diperbolehkan.");
        exit();
    }
    
    if ($file['size'] > $file_size_limit) {
        header("Location: form.php?error=Ukuran file maksimal 1MB.");
        exit();
    }

     // Simpan file
    $nama_file_baru = uniqid() . '_' . basename($file['name']);
    $target_path = $upload_dir . $nama_file_baru;
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        header("Location: form.php?error=Gagal mengunggah file.");
        exit();
    }

    // Simpan ke database
    $sql = "INSERT INTO peminjaman_ruangan (nama_agenda, nama_ruangan, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, peminjam, email_user, surat_permohonan) 
            VALUES ('$nama_agenda', '$nama_ruangan', '$tanggal_mulai', '$tanggal_selesai', '$jam_mulai', '$jam_selesai', '$peminjam', '$email_user', '$nama_file_baru')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: form.php?status=sukses");
        exit();
    } else {
        header("Location: form.php?status=gagal");
        exit();
    }
}
?>
