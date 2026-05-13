<?php
session_start();

// Menghapus semua data session (Soal 2)
session_unset();
session_destroy();

// Mengarahkan kembali ke halaman login setelah logout berhasil
header("Location: login.php");
exit;
?>