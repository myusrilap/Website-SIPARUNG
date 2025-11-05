<?php
include '../koneksi.php'; // Sesuaikan dengan file koneksi database Anda

$query = "SELECT id, nama_agenda, nama_ruangan, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, peminjam, status FROM peminjaman_ruangan WHERE status IN ('disetujui', 'ditolak')";
$result = mysqli_query($koneksi, $query);

$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    $color = ($row['status'] == 'disetujui') ? "#28a745" : "#dc3545"; // Hijau untuk disetujui, merah untuk ditolak
    $events[] = [
        "id"    => $row['id'],
        "title" => $row['nama_agenda'] . " - " . ucfirst($row['nama_ruangan']),
        "description" => $row['peminjam'],
        "start" => $row['tanggal_mulai'] . "T" . $row['jam_mulai'],
        "end"   => $row['tanggal_selesai'] . "T" . $row['jam_selesai'],
        "color" => $color
    ];
}

echo json_encode($events);
?>
