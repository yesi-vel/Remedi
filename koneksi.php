<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smarttraffic_cam";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>