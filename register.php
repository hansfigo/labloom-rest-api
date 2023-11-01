<?php
include 'connection.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    // Proses data login di sini
    $username = $data->username;
    $password = $data->password;

    // Periksa apakah username sudah ada dalam database
    $checkUsernameQuery = "SELECT * FROM admin WHERE username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        // Username sudah ada, kembalikan pesan error ke frontend
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array("message" => "Username sudah ada. Silakan pilih username lain."));
    } else {
        $hashed_password = password_hash($password, PASSWORD_ARGON2I);

        $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Data berhasil disimpan : $password"));
        } else {
            echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
        }
    }
}

$conn->close();
?>



