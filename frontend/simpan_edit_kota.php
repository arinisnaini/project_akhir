<?php
session_start();
if (!isset($_SESSION['token'])) {
    echo "Akses ditolak";
    exit;
}

$id = $_POST['id'];
$nama_kota = $_POST['nama_kota'];
$propinsi_id = $_POST['propinsi_id'];
$token = $_SESSION['token'];

// Data yang akan dikirim
$data = [
    'nama_kota' => $nama_kota,
    'propinsi_id' => $propinsi_id
];

// Inisialisasi cURL ke endpoint ID spesifik
$ch = curl_init('http://localhost:8000/api/kota/' . $id);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // PENTING: Gunakan method PUT
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Kirim data JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "<script>alert('Data berhasil diupdate!'); window.location='tampil_kota.php';</script>";
} else {
    echo "Gagal update data. Kode: " . $httpCode;
    echo "<br>Response: " . $response;
}
?>