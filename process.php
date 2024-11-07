<?php
// Koneksi ke database MySQL
$conn = new mysqli("localhost", "root", "", "zaqi");

// Periksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];

    // Cek apakah penulis sudah ada
    $checkAuthorQuery = "SELECT id FROM authors WHERE name = '$author'";
    $authorResult = $conn->query($checkAuthorQuery);

    if ($authorResult->num_rows > 0) {
        // Jika penulis sudah ada, ambil id penulis
        $authorRow = $authorResult->fetch_assoc();
        $author_id = $authorRow['id'];
    } else {
        // Jika penulis belum ada, masukkan penulis baru
        $insertAuthorQuery = "INSERT INTO authors (name) VALUES ('$author')";
        if ($conn->query($insertAuthorQuery) === TRUE) {
            $author_id = $conn->insert_id; // Ambil id penulis yang baru dimasukkan
        } else {
            echo "Error: " . $insertAuthorQuery . "<br>" . $conn->error;
        }
    }

    // Masukkan buku baru dengan id penulis
    $insertBookQuery = "INSERT INTO books (title, author_id) VALUES ('$title', '$author_id')";
    if ($conn->query($insertBookQuery) === TRUE) {
        // Redirect kembali ke halaman utama setelah input
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $insertBookQuery . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
