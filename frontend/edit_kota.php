<?php
session_start();
if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

$token = $_SESSION['token'];
$id = $_GET['id']; // Ambil ID dari URL

// 1. AMBIL DATA KOTA (untuk value default di form)
$ch = curl_init('http://localhost:8000/api/kota/' . $id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
$resKota = curl_exec($ch);
$kotaData = json_decode($resKota, true);
curl_close($ch);

// Cek jika data kota gagal diambil
if (!isset($kotaData['success']) || !$kotaData['success']) {
    die("Error: Gagal mengambil data kota.");
}
$kota = $kotaData['data']; // Array data kota

// 2. AMBIL DATA PROPINSI (untuk dropdown)
$ch2 = curl_init('http://localhost:8000/api/propinsi');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
$resProp = curl_exec($ch2);
$propinsi = json_decode($resProp, true);
curl_close($ch2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Kota</title>
</head>
<body>
    <h2>Edit Kota</h2>
    <form action="simpan_edit_kota.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $kota['id']; ?>">
        
        <label>Nama Kota:</label>
        <input type="text" name="nama_kota" value="<?php echo $kota['nama_kota']; ?>" required>
        <br><br>

        <label>Propinsi:</label>
        <select name="propinsi_id">
            <?php foreach ($propinsi as $p) { ?>
                <option value="<?php echo $p['id']; ?>" 
                    <?php echo ($p['id'] == $kota['propinsi_id']) ? 'selected' : ''; ?>>
                    <?php echo $p['nama_propinsi']; ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <button type="submit">Update</button>
        <a href="tampil_kota.php">Batal</a>
    </form>
</body>
</html>