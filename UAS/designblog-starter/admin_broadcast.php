<?php
include 'db.php';

// Ambil semua pesan broadcast
$stmt = $pdo->query("SELECT * FROM broadcasts ORDER BY created_at DESC");
$broadcasts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses untuk menambahkan pesan broadcast
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source = $_POST['source'];
    $message = $_POST['message'];

    $insert_stmt = $pdo->prepare("INSERT INTO broadcasts (source, message) VALUES (:source, :message)");
    $insert_stmt->bindParam(':source', $source);
    $insert_stmt->bindParam(':message', $message);
    $insert_stmt->execute();

    header("Location: admin_broadcast.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Broadcast</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e8f0fe; /* Light blue background */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            color: #003366; /* Dark blue for the main heading */
        }
        h2 {
            color: #0056b3; /* Medium blue for subheadings */
            margin-top: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            display: block;
            color: #0056b3; /* Medium blue for labels */
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #0056b3; /* Medium blue border */
            border-radius: 4px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007bff; /* Blue background for the submit button */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .broadcast {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px;
        }
        .broadcast strong {
            color: #007bff; /* Blue for the source */
        }
        .broadcast small {
            color: #666;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Admin Broadcast</h1>

    <h2>Tambahkan Pesan Broadcast</h2>
    <form method="post">
        <label for="source">Sumber:</label>
        <input type="text" id="source" name="source" required>
        <label for="message">Pesan:</label>
        <textarea id="message" name="message" rows="4" required></textarea>
        <input type="submit" value="Kirim">
    </form>

    <h2>Daftar Pesan Broadcast</h2>
    <?php foreach ($broadcasts as $broadcast): ?>
        <div class="broadcast">
            <strong>Sumber: <?php echo htmlspecialchars($broadcast['source']); ?></strong>
            <p><?php echo nl2br(htmlspecialchars($broadcast['message'])); ?></p>
            <small>Dikirim pada: <?php echo $broadcast['created_at']; ?></small>
        </div>
    <?php endforeach; ?>
</body>
</html>
