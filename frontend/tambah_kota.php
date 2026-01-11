<?php
session_start();
if (!isset($_SESSION['token'])) {
// header('Location: index.html');
 echo "Token sudah dihapus tidak dapat akses";
exit;
}
$token = $_SESSION['token'];
$user = $_SESSION['user'];
// baca tabel propinsi utk pilihan
$ch = curl_init('http://localhost:8000/api/propinsi');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'Authorization: Bearer ' . $token,
'Content-Type: application/json'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($httpCode == 200) {
$propinsi= json_decode($response, true);
} else {
echo 'Gagal mengambil data: ' . $httpCode;
echo '<pre>';
print_r(json_decode($response, true));
echo '</pre>';
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Kota</title>
</head>
<body>
<form action="simpan_tambah_kota.php" method="POST">
<label for="nama_kota">Nama Kota:</label>
<input type="text" id="nama_kota" name="nama_kota" required>
<br>
<label for="propinsi_id">ID Propinsi:</label>
<select name="propinsi_id" id="propinsi_id">
<option value="">-----------Pilih-----------</option>
<?php foreach ($propinsi as $p){ ?>
<option value="<?php echo $p['id']; ?>">
<?php echo $p['nama_propinsi'];?></option>
<?php }?>
</select>
<br>
<button type="submit">Simpan</button>
</form>
</body>
</html>