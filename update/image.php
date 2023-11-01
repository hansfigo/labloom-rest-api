<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $nim = $_POST['nim'];
    $gambar = $_FILES['gambar'];
    $gambarName = $gambar['name'];
    $gambarTmpName = $gambar['tmp_name'];

    // Direktori tempat Anda ingin menyimpan gambar (path relatif)
    $uploadDir = 'assets/img/';
    $gambarPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $uploadDir . $gambarName;

    // Variabel konfigurasi yang menyimpan domain
    $apiDir = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $uploadDir;

    $sql = "SELECT gambar FROM asisten WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc(); 
        $gambarString = $row["gambar"];     
        
        $base_url = 'https://' . $_SERVER['HTTP_HOST'] . '/assets/img/';

        $oldImage = substr($gambarString, strlen($base_url));
        $deleteImagePath = $uploadDir . $oldImage;
        if (file_exists($deleteImagePath)) {
            if (unlink($deleteImagePath)) {
                if (move_uploaded_file($gambarTmpName, $gambarPath)) {
                    $endpoindPath = $apiDir . $gambarName;
                    $sql = "UPDATE asisten SET gambar='$endpoindPath' WHERE nim='$nim'";
        
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
                $sql = "UPDATE asisten SET gambar='$endpoindPath' WHERE nim='$nim'";
    
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
