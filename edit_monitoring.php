<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$id = (int)$_GET['id']; // Mengambil ID dari URL (Soal 7)
$query = mysqli_query($conn, "SELECT * FROM monitoring WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $lokasi = $_POST['lokasi'];
    $waktu = $_POST['waktu'];
    $jumlah = (int)$_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    // Logika Status Otomatis (Soal 5)
    if($jumlah <= 20) $status = 'Lancar';
    elseif($jumlah <= 50) $status = 'Padat';
    else $status = 'Macet';

    $foto_lama = $data['foto_bukti'];
    $foto_baru = $_FILES['foto']['name'];

    if ($foto_baru != "") {
        // Jika upload foto baru (Soal 4)
        $ext = pathinfo($foto_baru, PATHINFO_EXTENSION);
        $newName = time() . "_" . $foto_baru;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $newName);
        // Hapus foto lama dari server
        unlink("uploads/" . $foto_lama);
        $foto_final = $newName;
    } else {
        $foto_final = $foto_lama;
    }

    $sql = "UPDATE monitoring SET 
            lokasi_cctv='$lokasi', 
            waktu_monitoring='$waktu', 
            jumlah_kendaraan='$jumlah', 
            status_kemacetan='$status', 
            deskripsi='$deskripsi', 
            foto_bukti='$foto_final' 
            WHERE id=$id";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: monitoring.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Monitoring</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Edit Data Monitoring</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Lokasi CCTV:</label>
            <input type="text" name="lokasi" value="<?= $data['lokasi_cctv'] ?>" required>
            
            <label>Waktu:</label>
            <input type="datetime-local" name="waktu" value="<?= date('Y-m-d\TH:i', strtotime($data['waktu_monitoring'])) ?>" required>
            
            <label>Jumlah Kendaraan:</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah_kendaraan'] ?>" required>
            
            <label>Deskripsi:</label>
            <textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea>
            
            <label>Foto Bukti (Kosongkan jika tidak diganti):</label><br>
            <img src="uploads/<?= $data['foto_bukti'] ?>" width="100"><br>
            <input type="file" name="foto">
            
            <button type="submit" name="update" class="btn btn-primary">Update Data</button>
            <a href="monitoring.php" class="btn btn-danger">Batal</a>
        </form>
    </div>
</body>
</html>