<?php
session_start();
require 'koneksi.php';
$id = $_GET['id'];

// Ambil nama file untuk dihapus dari server (Nilai Tambah Soal 4)
$data = mysqli_query($conn, "SELECT foto_bukti FROM monitoring WHERE id = $id");
$row = mysqli_fetch_assoc($data);
if ($row) {
    unlink("uploads/" . $row['foto_bukti']);
}

mysqli_query($conn, "DELETE FROM monitoring WHERE id = $id");
header("Location: monitoring.php");
?>