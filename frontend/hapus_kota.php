<?php
session_start();
if (!isset($_SESSION['token']) || !isset($_GET['id'])) {
    header('Location: tampil_kota.php');
    exit;
}

$id = $_GET['id'];
$token = $_SESSION['token'];

$ch = curl_init('http://localhost:8000/api/kota/' . $id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // PENTING: Gunakan method DELETE
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='tampil_kota.php';</script>";
} else {
    echo "Gagal menghapus data. Kode: " . $httpCode;
    echo "<br>Response: " . $response;
    echo "<br><a href='tampil_kota.php'>Kembali</a>";
}
?>