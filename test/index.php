<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buah</title>
</head>
<body>
    <h1>Daftar Buah</h1>
    <ul>
        <?php
        // Mengimpor data dari data.php
        require('data.php');

        // Mengiterasi melalui data buah dan merendernya sebagai elemen <li>
        foreach ($buah as $item) {
            echo "<li>Nama: {$item['nama']}, Warna: {$item['warna']}, Harga: {$item['harga']}</li>";
        }
        ?>
    </ul>
</body>
</html>
