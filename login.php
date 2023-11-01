<?php
include 'connection.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    

    // Proses data login di sini
    $username = $data->username;
    $password = $data->password;

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        // Username ditemukan, periksa password
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            echo json_encode(array("message" => "Berhasil Login"));
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(array("message" => "Pass Salah, Gagal Login : $hashed_password ..$password"));
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array("message" => "Username Salah,Gagal Login"));
    }
}

$conn->close();
?>



