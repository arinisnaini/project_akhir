<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Ambil data dari form
$email = $_POST['email'];
$password = $_POST['password'];
// Siapkan data untuk dikirim ke API
$postData = [
'email' => $email,
'password' => $password
];
// Inisialisasi cURL
$ch = curl_init('http://localhost:8000/api/auth/login');
// Setel opsi-opsi cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'Content-Type: application/x-www-form-urlencoded'
]);
// Eksekusi permintaan dan dapatkan hasil
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// Tutup koneksi cURL
curl_close($ch);
// Tampilkan hasil
if ($httpCode == 200) {
$data=json_decode($response, true);
$_SESSION['token'] = $data['token'];
$_SESSION['user'] = $data['data'];
echo $response;
exit;
} else {
echo 'Login gagal: ' . $httpCode;
echo '<pre>';
print_r(json_decode($response, true));
echo '</pre>';
}
} else {
echo 'Metode request tidak valid.';
}
?>