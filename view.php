<?php
include "index.php";

if(isset($_POST['submit'])){
    $nim = $_POST['nim'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $jurusan = $_POST['jurusan'] ?? '';
    $fakultas = $_POST['fakultas'] ?? '';
    $prodi = $_POST['prodi'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $angkatan = $_POST['angkatan'] ?? '';

    $sqlCheck = "SELECT nim FROM mahasiswa WHERE nim = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $nim);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    if ($resultCheck->num_rows > 0) {
        echo "Error: Duplicate NIM";
    } else {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan, fakultas, prodi, kelas, angkatan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nim, $nama, $jurusan, $fakultas, $prodi, $kelas, $angkatan);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $stmtCheck->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Data Mahasiswa</title>
</head>
<body>
        <table class="table">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Fakultas</th>
                <th>Prodi</th>
                <th>Kelas</th>
                <th>Angkatan</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT nim, nama, jurusan, fakultas, prodi, kelas, angkatan FROM mahasiswa";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nim"] . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["jurusan"] . "</td>";
                    echo "<td>" . $row["fakultas"] . "</td>";
                    echo "<td>" . $row["prodi"] . "</td>";
                    echo "<td>" . $row["kelas"] . "</td>";
                    echo "<td>" . $row["angkatan"] . "</td>";
                    echo "<td><a href='update.php?nim=" . $row["nim"] . "'>Update</a> | <a href='delete.php?nim=" . $row["nim"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No data found</td></tr>";
            }
            ?>
            <?php $conn->close(); ?>
        </table>
    </div>
</body>
</html>

