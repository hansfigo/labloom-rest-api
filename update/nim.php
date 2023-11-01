<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $newNim = $_POST['newNim'];
    $nim = $_POST['nim'];

    $sql = "UPDATE asisten SET nim='$newNim' WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(array("message" => "Success : Data Berhasil Diupdatem Nama .$newNim" ));
    } else {
        echo json_encode(array("message" => "Error: Data tidak Ditemukan .$newNim" ));
    }
   
}
$conn->close();

?>