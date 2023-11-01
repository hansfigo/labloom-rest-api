<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];

    $sql = "UPDATE asisten SET nama='$nama' WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(array("message" => "Success : Data Berhasil Diupdatem Nama .$nama" ));
    } else {
        echo json_encode(array("message" => "Error: Data tidak Ditemukan .$nim" ));
    }
   
}
$conn->close();

?>