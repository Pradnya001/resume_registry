<?php
require_once "pdo.php";
if (!isset($_GET['profile_id'])) {
    die("Missing profile_id");
}
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid");
$stmt->execute([':pid' => $_GET['profile_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    die("Profile not found");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.view-box {
    background-color: #fff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

p {
    font-size: 16px;
    margin-bottom: 15px;
    color: #444;
}

.back-button {
    display: block;
    text-align: center;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #0078D7;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
}

.back-button:hover {
    background-color: #005fa3;
}

    </style>
</head>
<body>
    <div class="view-box">
        <h1>👤 <?= htmlentities($row['first_name']) ?> <?= htmlentities($row['last_name']) ?></h1>
        <p>📧 <strong>Email:</strong> <?= htmlentities($row['email']) ?></p>
        <p>💼 <strong>Headline:</strong> <?= htmlentities($row['headline']) ?></p>
        <p>📝 <strong>Summary:</strong><br><?= nl2br(htmlentities($row['summary'])) ?></p>
        <a href="index.php">Back</a>
    </div>
</body>

</html>