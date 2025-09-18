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
    $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id = :pid");
    $stmt->execute([':pid' => $_GET['profile_id']]);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🗑️ Delete Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .delete-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #dc3545;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        input[type="submit"],
        .cancel-button {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin: 5px;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
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
    <div class="delete-box">
        <h1>🗑️ Delete Profile</h1>
        <p>Are you sure you want to delete this profile?</p>
        <form method="post">
            <input type="submit" value="✅ Confirm">
            <a href="index.php">❌ Cancel</a>
        </form>
    </div>
</body>
</html>
