<?php
session_start();
require 'koneksi.php';

// Proteksi halaman: Jika belum login, arahkan ke login.php (Soal 2)
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

$uid = $_SESSION['user_id'];

// Ambil data monitoring berdasarkan user yang sedang login (Soal 3)
$query = "SELECT * FROM monitoring WHERE user_id = $uid ORDER BY waktu_monitoring DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Monitoring - SmartTraffic Cam</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Daftar Pantauan CCTV</h2>
        <p>Kelola data kemacetan lalu lintas di titik strategis kota.</p>
        
        <div class="action-top">
            <a href="tambah_monitoring.php" class="btn btn-primary">+ Tambah Data Monitoring</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Lokasi CCTV</th>
                    <th>Waktu Monitoring</th>
                    <th>Jumlah Kendaraan</th>
                    <th>Status</th>
                    <th>Deskripsi Kondisi</th>
                    <th>Bukti Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['lokasi_cctv']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['waktu_monitoring'])) ?></td>
                        <td><?= $row['jumlah_kendaraan'] ?></td>
                        <td>
                            <span class="status-label <?= strtolower($row['status_kemacetan']) ?>">
                                <?= $row['status_kemacetan'] ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        
                        <!-- Kolom Bukti Foto dengan Thumbnail -->
                        <td>
                            <?php if ($row['foto_bukti']): ?>
                                <a href="uploads/<?= $row['foto_bukti'] ?>" target="_blank">
                                    <img src="uploads/<?= $row['foto_bukti'] ?>" class="img-thumbnail" alt="Bukti CCTV">
                                </a>
                            <?php else: ?>
                                <span style="color: #999; font-style: italic;">Tidak ada foto</span>
                            <?php endif; ?>
                        </td>

                        <!-- Kolom Aksi dengan Button Terpisah -->
                        <td>
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <a href="edit_monitoring.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="hapus_monitoring.php?id=<?= $row['id'] ?>" class="btn btn-hapus" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data monitoring di <?= $row['lokasi_cctv'] ?>?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Belum ada data monitoring. Silakan tambah data baru.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>