<?php 
include "index.php";

if(isset($_GET['nim'])){
    $nim = $_GET['nim'];
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);

    if ($stmt->execute()) {
        header("Location: view.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>