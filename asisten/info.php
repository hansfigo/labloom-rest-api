<?php
include '../connection.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nim = $_GET['nim'];

    $sql = "SELECT * FROM asisten WHERE nim = '$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Mengambil satu baris hasil
        echo json_encode($row);
    } else {
        echo json_encode(array("message" => "Error"));
    }
}

$conn->close();
?>



