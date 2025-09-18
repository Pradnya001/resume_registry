<?php
session_start();
require_once "pdo.php";
$profiles = $pdo->query("SELECT profile_id, first_name, headline FROM Profile")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Resume Registry</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #fdfbfb, #ebedee);
        margin: 0;
        padding: 40px;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    a {
        color: #0078D7;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .top-links {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        max-width: 800px;
        margin: 0 auto 30px auto;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #0078D7;
        color: white;
        font-size: 16px;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .action-links a {
        margin-right: 10px;
        color: #0078D7;
        text-decoration: none;
        font-weight: bold;
    }

    .action-links a:hover {
        text-decoration: underline;
    }

    .add-entry {
        text-align: center;
        margin-top: 20px;
    }

    .add-entry a {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }

    .add-entry a:hover {
        background-color: #218838;
    }

    .note {
        text-align: center;
        margin-top: 30px;
        font-size: 14px;
        color: #555;

    .logout-button {
    display: inline-block;
    background-color: #dc3545;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    margin: 10px auto;
    text-align: center;
}

.logout-button:hover {
    background-color: #c82333;
}

.add-entry {
    text-align: center;
    margin-top: 30px;
}

.add-entry a {
    background-color: #0078D7;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
    display: inline-block;
}

.add-entry a:hover {
    background-color: #005fa3;
}

    }
</style>
</head>
<body>
<h1>Pradnya's Resume Registry</h1>
<?php if (!isset($_SESSION['user_id'])): ?>
    <div class="top-links">
         <a href='login.php'>🔐 Please log in</a>
    </div>
<?php else: ?>
    <div class="top-links">
        <a href="logout.php">🚪 Logout</a>
    </div>
<?php endif; ?>

<table border="1">
    <tr><th>Name</th><th>Headline</th><th>Action</th></tr>
    <?php foreach ($profiles as $row): ?>
        <tr>
            <td><a href="view.php?profile_id=<?= $row['profile_id'] ?>"><?= htmlentities($row['first_name']) ?></a></td>
            <td><?= htmlentities($row['headline']) ?></td>
            <?php if (isset($_SESSION['user_id'])): ?>
                <td>
                    <a href="view.php?profile_id=<?= $row['profile_id'] ?>">👁️ View</a>
                    <a href="edit.php?profile_id=<?= $row['profile_id'] ?>">✏️ Edit</a>
                    <a href="delete.php?profile_id=<?= $row['profile_id'] ?>">🗑️ Delete</a>
                </td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="add-entry">
        <a href="add.php"> Add New Entry</a>
    </div>
<?php endif; ?>

<p>Note: Your implementation should retain data across multiple logout/login sessions.</p>
</body>
</html>