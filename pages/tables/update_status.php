<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $status = mysqli_real_escape_string($koneksi, $_GET['status']);

    // Update status peminjaman
    $query = "UPDATE peminjaman_ruangan SET status='$status' WHERE id='$id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect ke jadwal.php dengan parameter berhasil
        header("Location: jadwal.php?status=berhasil");
        exit();
    } else {
        // Redirect ke jadwal.php dengan parameter gagal
        header("Location: jadwal.php?status=gagal");
        exit();
    }
} else {
    // Jika parameter tidak lengkap
    header("Location: jadwal.php");
    exit();
}

?>
