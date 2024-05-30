<?php
include "index.php";

if(isset($_GET['nim'])){
    $nim = $_GET['nim'];
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if($data) {
        if(isset($_POST['submit'])){
            $nama = $_POST['nama'] ?? $data['nama'];
            $jurusan = $_POST['jurusan'] ?? $data['jurusan'];
            $fakultas = $_POST['fakultas'] ?? $data['fakultas'];
            $prodi = $_POST['prodi'] ?? $data['prodi'];
            $kelas = $_POST['kelas'] ?? $data['kelas'];
            $angkatan = $_POST['angkatan'] ?? $data['angkatan'];

            if (empty($nama) || empty($jurusan) || empty($fakultas) || empty($prodi) || empty($kelas) || empty($angkatan)) {
                echo "Mohon Isi Data Tertera!";
            } else {
                $stmtUpdate = $conn->prepare("UPDATE mahasiswa SET nama=?, jurusan=?, fakultas=?, prodi=?, kelas=?, angkatan=? WHERE nim=?");
                $stmtUpdate->bind_param("sssssss", $nama, $jurusan, $fakultas, $prodi, $kelas, $angkatan, $nim);

                if ($stmtUpdate->execute()) {
                    echo "Record updated successfully";
                    header("Location: view.php");
                    exit();
                } else {
                    echo "Error updating record: " . $stmtUpdate->error;
                }

                $stmtUpdate->close();
            }
        }
    } else {
        echo "No record found for the provided NIM.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Update Form Mahasiswa</h2>
    <form action="" method="post">
        <input type="text" name="nama" id="nama" placeholder="Nama" value="<?php echo $data['nama'] ?? ''; ?>">
        <input type="text" name="jurusan" id="jurusan" placeholder="Jurusan" value="<?php echo $data['jurusan'] ?? ''; ?>">
        <input type="text" name="fakultas" id="fakultas" placeholder="Fakultas" value="<?php echo $data['fakultas'] ?? ''; ?>">
        <input type="text" name="prodi" id="prodi" placeholder="Prodi" value="<?php echo $data['prodi'] ?? ''; ?>">
        <input type="text" name="kelas" id="kelas" placeholder="Kelas" value="<?php echo $data['kelas'] ?? ''; ?>">
        <input type="text" name="angkatan" id="angkatan" placeholder="Angkatan" value="<?php echo $data['angkatan'] ?? ''; ?>">
        <button type="submit" name="submit">Update</button>
    </form>
</body>
</html>
