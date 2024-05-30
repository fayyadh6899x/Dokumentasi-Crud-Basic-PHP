<?php
include "index.php";

if(isset($_POST['submit'])){
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $kelas = $_POST['kelas'];
    $angkatan = $_POST['angkatan'];

    if (empty($nim) || empty($nama) || empty($jurusan) || empty($fakultas) || empty($prodi) || empty($kelas) || empty($angkatan)) {
        echo "Mohon Isi Data Tertera!";
    } else {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (`nim`, `nama`, `jurusan`, `fakultas`, `prodi`, `kelas`, `angkatan`) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `nama`=?, `jurusan`=?, `fakultas`=?, `prodi`=?, `kelas`=?, `angkatan`=?");
        $stmt->bind_param("sssssssssssss", $nim, $nama, $jurusan, $fakultas, $prodi, $kelas, $angkatan, $nama, $jurusan, $fakultas, $prodi, $kelas, $angkatan);

        if ($stmt->execute()) {
            header("Location: view.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "No data submitted";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<h2>Form Mahasiswa</h2>

<form action="" method="post">
    <input type="text" name="nim" id="nim" placeholder="NIM">
    <input type="text" name="nama" id="nama" placeholder="Nama">
    <input type="text" name="jurusan" id="jurusan" placeholder="Jurusan">
    <input type="text" name="fakultas" id="fakultas" placeholder="Fakultas">
    <input type="text" name="prodi" id="prodi" placeholder="Prodi">
    <input type="text" name="kelas" id="kelas" placeholder="Kelas">
    <input type="text" name="angkatan" id="angkatan" placeholder="Angkatan">
    <button type="submit" name="submit">Submit</button>
</form>
</body>


</html>


