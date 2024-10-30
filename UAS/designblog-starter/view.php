<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Update view count
    $update_stmt = $pdo->prepare("UPDATE articles SET view_count = view_count + 1 WHERE id = :id");
    $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_stmt->execute();

    // Ambil artikel untuk ditampilkan
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Periksa apakah artikel ditemukan
    if (!$article) {
        die("Artikel tidak ditemukan.");
    }
} else {
    // Jika tidak ada ID yang diberikan
    die("ID artikel tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <style>
        /* Gaya Anda di sini */
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($article['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
    <p>Views: <?php echo $article['view_count']; ?></p>
    <a href="index.php">Kembali ke Daftar Artikel</a>
</body>
</html>
