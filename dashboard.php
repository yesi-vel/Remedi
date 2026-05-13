<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

$uid = $_SESSION['user_id'];

// Ambil statistik (Soal 6)
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM monitoring WHERE user_id = $uid"))['c'];
$lancar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM monitoring WHERE user_id = $uid AND status_kemacetan = 'Lancar'"))['c'];
$padat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM monitoring WHERE user_id = $uid AND status_kemacetan = 'Padat'"))['c'];
$macet = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM monitoring WHERE user_id = $uid AND status_kemacetan = 'Macet'"))['c'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SmartTraffic Cam</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        <div class="card-container">
            <h2 style="margin-top: 0; color: #b7bbceff;">Halo, <?= $_SESSION['nama'] ?>!</h2>
            <p style="color: #efe7e7ff;">Ringkasan data monitoring lalu lintas di sistem Anda saat ini.</p>
            
            <div class="card-grid">
                <div class="card">
                    <h3>Total Data</h3>
                    <p><?= $total ?></p>
                </div>

                <div class="card" style="border-top-color: #2ecc71;">
                    <h3>Lancar</h3>
                    <p style="color: #27ae60;"><?= $lancar ?></p>
                </div>

                <div class="card" style="border-top-color: #f1c40f;">
                    <h3>Padat</h3>
                    <p style="color: #f39c12;"><?= $padat ?></p>
                </div>

                <div class="card" style="border-top-color: #e74c3c;">
                    <h3>Macet</h3>
                    <p style="color: #c0392b;"><?= $macet ?></p>
                </div>
            </div>

            <div class="btn-center">
                <a href="monitoring.php" class="btn-primary" style="text-decoration: none; display: inline-block;">Lihat Detail Monitoring</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>