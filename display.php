<?php
// Koneksi ke database MySQL
$conn = new mysqli("localhost", "root", "", "library_db");

// Periksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data buku dan penulis
$sql = "SELECT books.title AS book_title, authors.name AS author_name 
        FROM books 
        JOIN authors ON books.author_id = authors.id";
$result = $conn->query($sql);

// Tampilkan data dalam bentuk tabel
if ($result->num_rows > 0) {
    // Loop untuk menampilkan setiap baris data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['book_title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
        echo "</tr>";
    }
} else {
    // Jika tidak ada data, tampilkan pesan kosong
    echo "<tr><td colspan='2'>Tidak ada data ditemukan</td></tr>";
}

// Tutup koneksi
$conn->close();
?>
