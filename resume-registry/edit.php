<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['user_id'])) {
    die("🚫 Not logged in");
}
if (!isset($_GET['profile_id'])) {
    die("❌ Missing profile_id");
}

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid");
$stmt->execute([':pid' => $_GET['profile_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || $row['user_id'] != $_SESSION['user_id']) {
    die("⛔ Not authorized");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("UPDATE Profile SET first_name = :fn, last_name = :ln, email = :em, headline = :hl, summary = :su WHERE profile_id = :pid");
    $stmt->execute([
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':su' => $_POST['summary'],
        ':pid' => $_GET['profile_id']
    ]);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>✏️ Edit Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #c3cfe2, #f5f7fa);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edit-box {
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
            background-color: #28a745;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="edit-box">
        <h1>✏️ Edit Your Profile</h1>
        <form method="post">
            <input type="text" name="first_name" placeholder="🧑 First Name" value="<?= htmlentities($row['first_name']) ?>">
            <input type="text" name="last_name" placeholder="👤 Last Name" value="<?= htmlentities($row['last_name']) ?>">
            <input type="email" name="email" placeholder="📧 Email" value="<?= htmlentities($row['email']) ?>">
            <input type="text" name="headline" placeholder="💼 Headline" value="<?= htmlentities($row['headline']) ?>">
            <textarea name="summary" placeholder="📝 Summary"><?= htmlentities($row['summary']) ?></textarea>
            <input type="submit" value="💾 Save">
            <a href="index.php">❌ Cancel</a>
        </form>
    </div>
</body>
</html>
