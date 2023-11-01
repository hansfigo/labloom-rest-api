<?php
include 'connection.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM asisten";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $asisten = array();
        while ($row = $result->fetch_assoc()) {
            $asisten[] = $row;
        }
        echo json_encode($asisten);
    } else {
        echo json_encode(array());
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];

    // Mendapatkan informasi tentang file gambar yang diunggah
    $gambar = $_FILES['gambar'];
    $gambarName = $gambar['name'];
    $gambarTmpName = $gambar['tmp_name'];

    // Direktori tempat Anda ingin menyimpan gambar (path relatif)
    $uploadDir = 'assets/img/';
    $gambarPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $uploadDir . $gambarName;
    $apiDir = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $uploadDir; // Menggunakan HTTP_HOST untuk mendapatkan domain dinamis

    // Pindahkan file gambar yang diunggah ke direktori yang ditentukan
    if (move_uploaded_file($gambarTmpName, $gambarPath)) {
        $endpoindPath = $apiDir . $gambarName;
        $sql = "INSERT INTO asisten (nim, nama, prodi, gambar) VALUES ('$nim', '$nama', '$prodi', '$endpoindPath')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Data berhasil disimpan"));
        } else {
            echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
        }
    } else {
        echo json_encode(array("message" => "Gagal mengunggah gambar"));
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $nim = $_GET['nim'];


    $sql = "DELETE FROM asisten WHERE nim = '$nim';";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Data berhasil DiDelete"));
    } else {
        echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
    }

    echo json_encode(array($id));
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
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

    $sql = "SELECT gambar FROM asisten WHERE nim='$id'";

    if ($result->num_rows > 0) {
        // Ambil data dari hasil query
        $row = $result->fetch_assoc();
        $gambarString = $row["gambar"];
        
        $base_url = 'http://localhost:8000/assets/img/';

        $deleteImagePath = substr($gambarString, strlen($base_url));

        if (unlink($deleteImagePath)) {
            if (move_uploaded_file($gambarTmpName, $gambarPath)) {
                $endpoindPath = $apiDir . $gambarName;
                $sql = "UPDATE asisten SET nim='$nim', nama='$nama', prodi='$prodi', gambar='$endpoindPath' WHERE nim='$id'";
    
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
    } else {
        echo json_encode(array("message" => "Error: Data tidak Ditemukan" ));
    }
   
}
$conn->close();
?>



