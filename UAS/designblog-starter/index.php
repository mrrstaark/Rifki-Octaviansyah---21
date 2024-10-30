<?php
include 'db.php';

// Pagination
$limit = 5; // jumlah artikel per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil 5 artikel terbaru
$stmt = $pdo->prepare("SELECT * FROM articles ORDER BY created_at DESC LIMIT :offset, :limit");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil total artikel untuk pagination
$total_stmt = $pdo->query("SELECT COUNT(*) FROM articles");
$total_articles = $total_stmt->fetchColumn();
$total_pages = ceil($total_articles / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
    <style>
        /* Tambahkan CSS sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .article {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Artikel Terbaru</h1>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <h2><?php echo htmlspecialchars($article['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
            <p>Views: <?php echo $article['view_count']; ?></p>
            <a href="view.php?id=<?php echo $article['id']; ?>">Baca Selengkapnya</a>
        </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <div>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>
