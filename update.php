<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];


    $gambar = $_FILES['gambar'];
    $gambarName = $gambar['name'];
    $gambarTmpName = $gambar['tmp_name'];

    $uploadDir = 'D:/coding/php/API-Test/assets/img/';
    $apiDir = 'http://localhost:8000/assets/img/';
    $gambarPath = $uploadDir . $gambarName;

    $sql = "SELECT gambar FROM asisten WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result) {
        // Ambil data dari hasil query
        $row = $result->fetch_assoc(); // Mengambil satu baris hasil
        $gambarString = $row["gambar"];     
        
        $base_url = 'http://localhost:8000/assets/img/';

        $oldImage = substr($gambarString, strlen($base_url));
        $deleteImagePath = $uploadDir . $oldImage;
        if (file_exists($deleteImagePath)) {
            if (unlink($deleteImagePath)) {
                if (move_uploaded_file($gambarTmpName, $gambarPath)) {
                    $endpoindPath = $apiDir . $gambarName;
                    $sql = "UPDATE asisten SET nim='$nim', nama='$nama', prodi='$prodi', gambar='$endpoindPath' WHERE nim='$nim'";
        
                    if ($conn->query($sql) === TRUE) {
                        echo json_encode(array("message" => "Data berhasil disimpan"));
                    } else {
                        echo json_encode(array("message" => "Error: "));
                    }
                } else {
                    echo json_encode(array("message" => "Gagal mengunggah gambar"));
                }
            
            } else {
                echo json_encode(array("message" => "Error: Gagal Hapus File" ));
            }
        }else{
            if (move_uploaded_file($gambarTmpName, $gambarPath)) {
                $endpoindPath = $apiDir . $gambarName;
                $sql = "UPDATE asisten SET nim='$nim', nama='$nama', prodi='$prodi', gambar='$endpoindPath' WHERE nim='$nim'";
    
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Data berhasil disimpan"));
                } else {
                    echo json_encode(array("message" => "Error: "));
                }
            } else {
                echo json_encode(array("message" => "Gagal mengunggah gambar"));
            }
        }
        
    } else {
        echo json_encode(array("message" => "Error: Data tidak Ditemukan .$nim" ));
    }
   
}
$conn->close();

?>