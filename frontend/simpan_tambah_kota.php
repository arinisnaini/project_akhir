<?php
session_start();
if (!isset($_SESSION['token'])) {
 echo "Token sudah dihapus tidak dapat akses";
// header('Location: index.html');
exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$nama_kota = $_POST['nama_kota'];
$propinsi_id = $_POST['propinsi_id'];
$token = $_SESSION['token'];
$postData = [
'nama_kota' => $nama_kota,
'propinsi_id' => $propinsi_id
];
$ch = curl_init('http://localhost:8000/api/kota');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'Authorization: Bearer ' . $token,
'Content-Type: application/json'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($httpCode == 200) {
echo 'Kota berhasil ditambahkan!';
header('Location: tampil_kota.php');
} else {
echo 'Gagal menambahkan kota: ' . $httpCode;
echo '<pre>';
print_r(json_decode($response, true));
echo '</pre>';
}
} else {
echo 'Metode request tidak valid.';
}
?>