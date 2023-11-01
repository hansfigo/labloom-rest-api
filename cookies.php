<?php
include 'connection.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    // Proses data login di sini
    $username = $data->username;
    $token = $data->token;

    // Periksa apakah username sudah ada dalam database
    $updateToken = "UPDATE admin SET authToken = '$token' WHERE username = '$username'";

    if ($conn->query($updateToken) === TRUE) {
        echo json_encode(array("message" => "Berhasil Login"));
    } else {
        echo json_encode(array("message" => "error Login"));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'];

    $sql = "SELECT username FROM admin WHERE authToken = '$token'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc(); // Mengambil satu baris hasil
        $username = $row['username'];
        echo json_encode($username);                    
    } else {
        echo json_encode(array("message" => "error Login"));
    }
}

$conn->close();
?>



