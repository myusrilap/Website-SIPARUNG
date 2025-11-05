<?php

$server = 'localhost';
$user = 'root';
$pass = '';
$database = 'peminjaman_ruang';

// Buat koneksi
$koneksi = mysqli_connect($server, $user, $pass, $database);

if(!$koneksi) {
    die('Koneksi Gagal: ' . mysqli_connect_error());
}
