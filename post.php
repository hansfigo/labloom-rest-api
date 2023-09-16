<?php
// Set header untuk mengindikasikan bahwa ini adalah response JSON
header('Content-Type: application/json');

// Cek jika permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menerima data JSON dari permintaan POST
    $data = json_decode(file_get_contents('php://input'));

    // Cek apakah data telah diterima dengan benar
    if ($data) {
        // Di sini Anda dapat memproses data sesuai kebutuhan Anda
        // Contoh: Mengembalikan data yang sama
        echo json_encode($data);
    } else {
        // Jika data tidak diterima dengan benar, kirim respons error
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Data JSON tidak valid.'));
    }
} else {
    // Jika bukan permintaan POST, kirim respons error
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Metode tidak diizinkan.'));
}
?>
