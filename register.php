<?php
require 'koneksi.php';
if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi password minimal 6 karakter (Soal 8)
    if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$hashed_pw')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - SmartTraffic Cam</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h2>Daftar Akun</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password (min 6 karakter)" required>
            <button type="submit" name="register" class="btn btn-primary" style="width: 100%;">Daftar</button>
        </form>
        <p class="login-link">
    Sudah punya akun? 
    <a href="login.php">Login di sini</a>
</p>
    </div>
</body>
</html>