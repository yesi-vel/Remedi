<?php
session_start();
require 'koneksi.php';

if (isset($_POST['submit'])) {
    $uid = $_SESSION['user_id'];
    $lokasi = $_POST['lokasi'];
    $waktu = $_POST['waktu'];
    $jumlah = (int)$_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    // Soal 5: Logika PHP Status Otomatis
    if($jumlah <= 20) $status = 'Lancar';
    elseif($jumlah <= 50) $status = 'Padat';
    else $status = 'Macet';

    // Upload File (Soal 4)
    $foto = $_FILES['foto']['name'];
    
    $tmp = $_FILES['foto']['tmp_name'];
    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png'];

    if(in_array(strtolower($ext), $allowed)) {

    $newName = time() . "_" . $foto;

    if(move_uploaded_file($tmp, "uploads/" . $newName)){

        
        $sql = "INSERT INTO monitoring 
(user_id, lokasi_cctv, waktu_monitoring, jumlah_kendaraan, status_kemacetan, deskripsi, foto_bukti)

VALUES
('$uid', '$lokasi', '$waktu', '$jumlah', '$status', '$deskripsi', '$newName')";

if(mysqli_query($conn, $sql)){

    header("Location: monitoring.php");
    exit;

} else {

    echo mysqli_error($conn);
}
    } else {

        echo "UPLOAD GAGAL";
    }

}
        
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Tambah Pantauan Baru</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="lokasi" placeholder="Lokasi CCTV" required>
            <input type="datetime-local" name="waktu" required>
            <input type="number" name="jumlah" placeholder="Jumlah Kendaraan" required>
            <textarea name="deskripsi" placeholder="Deskripsi Kondisi"></textarea>
            <label class="form-label">Bukti Foto (JPG/PNG):</label>
            <input type="file" name="foto" required>
            <div class="form-action">
    <button type="submit" name="submit" class="btn btn-primary">
        Simpan Data
    </button>
</div>
        </form>
    </div>
</body>
</html>