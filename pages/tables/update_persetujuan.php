<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $file = $_FILES['surat_persetujuan'];

    $allowed_ext = 'pdf';
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_size_limit = 1 * 1024 * 1024; // 1MB
    $upload_dir = '../uploads/persetujuan/';
    $new_filename = uniqid() . '.' . $file_ext;

    if ($file_ext !== $allowed_ext) {
        header("Location: jadwal.php?modal=error&message=Hanya+file+PDF+yang+diizinkan");
        exit();
    }

    if ($file['size'] > $file_size_limit) {
        header("Location: jadwal.php?modal=error&message=Ukuran+file+maksimal+1MB");
        exit();
    }

    if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_filename)) {
        $sql = "UPDATE peminjaman_ruangan SET surat_persetujuan='$new_filename' WHERE id='$id'";
        if (mysqli_query($koneksi, $sql)) {
            header("Location: jadwal.php?modal=success&message=Surat+persetujuan+berhasil+diunggah");
            exit();
        } else {
            header("Location: jadwal.php?modal=error&message=Gagal+menyimpan+ke+database");
            exit();
        }
    } else {
        header("Location: jadwal.php?modal=error&message=Gagal+mengunggah+file");
        exit();
    }
}
?>
