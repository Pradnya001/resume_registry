<?php
session_start();
require_once "pdo.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pass'])) {
        $error = "⚠️ All fields are required";
    } else if (strpos($_POST['email'], '@') === false) {
        $error = "📧 Email address must contain @";
    } else {
        $salt = "XyZzy12*_";
        $check = hash('md5', $salt . $_POST['pass']);

        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :em");
        $stmt->execute([':em' => $_POST['email']]);

        if ($stmt->fetch()) {
            $error = "❌ Email already registered";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:n, :e, :p)");
            $stmt->execute([
                ':n' => $_POST['name'],
                ':e' => $_POST['email'],
                ':p' => $check
            ]);
            $_SESSION['register_success'] = "✅ Registration successful. Please log in.";
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>📝 Register</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-box h1 {
            color: #333;
            margin-bottom: 25px;
            font-size: 28px;
        }

        .register-box input[type="text"],
        .register-box input[type="email"],
        .register-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }

        .register-box input:focus {
            border-color: #a6c1ee;
            outline: none;
            box-shadow: 0 0 5px rgba(166, 193, 238, 0.5);
        }

        .register-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #6a11cb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .register-box input[type="submit"]:hover {
            background-color: #5a0ebc;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .back-link {
            margin-top: 20px;
            font-size: 15px;
        }

        .back-link a {
            color: #0078D7;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h1>📝 Create Your Account</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlentities($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="name" placeholder="👤 Full Name">
            <input type="email" name="email" placeholder="📧 Email">
            <input type="password" name="pass" placeholder="🔒 Password">
            <input type="submit" value="🚀 Register">
        </form>

        <div class="back-link">
            <p>🔙 Already registered? <a href="login.php">Login Here</a></p>
        </div>
    </div>
</body>
</html>
