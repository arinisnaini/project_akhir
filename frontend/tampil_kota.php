<?php
session_start();
if (!isset($_SESSION['token'])) {
// header('Location: index.html');
 echo "Token sudah dihapus tidak dapat akses";
exit;
}
$token = $_SESSION['token'];
$user = $_SESSION['user'];
$ch = curl_init('http://localhost:8000/api/kota');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'Authorization: Bearer '.$token,
'Content-Type: application/json',
'Accept: application/json'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($httpCode == 200) {
$kota= json_decode($response, true);
//print_r(json_decode($response, true));
//echo $user['name'];
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
<title>Records</title>
</head>
<body>
<h1>Data Rekaman Kota</h1>
<?php if (!empty($kota)) : ?>
<table border="1">
<tr><td>ID</td><td>KOTA</td><td>KODE PROP</td></tr>
<?php foreach ($kota as $k) : ?>
<tr><td><?php echo $k['id']; ?></td>
<td><?php echo $k['nama_kota']; ?></td>
<td><?php echo $k['propinsi_id']; ?></td>
<td>
        <a href="edit_kota.php?id=<?php echo $k['id']; ?>">Edit</a> 
        | 
        <a href="hapus_kota.php?id=<?php echo $k['id']; ?>" 
           onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
<?php else : ?>
<p>Tidak ada data rekaman.</p>
<?php endif; ?>
<a href="logout.php">Logout</a>
</body>
</html>