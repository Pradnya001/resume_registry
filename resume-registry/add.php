<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES (:uid, :fn, :ln, :em, :hl, :su)");
    $stmt->execute([
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':su' => $_POST['summary']
    ]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0c3fc, #8ec5fc);
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.add-box {
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
    margin-bottom: 30px;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

textarea {
    resize: vertical;
    height: 100px;
}

input[type="submit"],
.cancel-button {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-right: 10px;
}

input[type="submit"] {
    background-color: #0078D7;
    color: white;
}

input[type="submit"]:hover {
    background-color: #005fa3;
}

.cancel-button {
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    display: inline-block;
}

.cancel-button:hover {
    background-color: #5a6268;
}

    </style>
</head>
<body>
    <div class="add-box">
        <h1>➕ Add Profile</h1>
        <form method="post">
            <input type="text" name="first_name" placeholder="🧑 First Name">
            <input type="text" name="last_name" placeholder="👤 Last Name">
            <input type="email" name="email" placeholder="📧 Email">
            <input type="text" name="headline" placeholder="💼 Headline">
            <textarea name="summary" placeholder="📝 Summary"></textarea>
            <input type="submit" value="✅ Add">
            <a href='index.php'>❌ Cancel</a>
        </form>
    </div>
</body>

</html>