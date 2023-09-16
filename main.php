<?php
include 'connection.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json');
header('Content-Type: application/json');


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

    if (empty($data->nama) || empty($data->nim) || empty($data->prodi)) {
        // Jika salah satu field kosong, kembalikan pesan kesalahan
        echo json_encode(array("message" => "Semua field harus diisi"));
    } else {
        $nama = $data->nama;
        $nim = $data->nim;
        $prodi = $data->prodi;

        $sql = "INSERT INTO asisten (nim, nama, prodi) VALUES ('$nim', '$nama', '$prodi')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Data berhasil disimpan"));
        } else {
            echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
        }
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

    $id = $_GET['nim']; // Pastikan Anda validasi dan bersihkan input ini jika diperlukan
    $nama = $data->nama;
    $nim = $data->nim;
    $prodi = $data->prodi;

    // Gunakan tanda kutip untuk nilai string
    $sql = "UPDATE asisten
    SET nim='$nim', nama='$nama', prodi='$prodi'
    WHERE nim='$id'";


    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Data berhasil DiDelete"));
    } else {
        echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
    }

    echo json_encode(array($id));
}
$conn->close();
?>



