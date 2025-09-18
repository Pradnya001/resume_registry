<?php
session_start();
require_once "pdo.php";

$error = '';
$show_register = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email']) || empty($_POST['pass'])) {
        $error = "⚠️ Both fields are required";
    } else if (strpos($_POST['email'], '@') === false) {
        $error = "📧 Email address must contain @";
    } else {
        $salt = "XyZzy12*_";
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $check = hash('md5', $salt . $pass);

        $stmt = $pdo->prepare("SELECT user_id, name, password FROM users WHERE email = :em");
        $stmt->execute([':em' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            $error = "❌ Email not found. Please register.";
            $show_register = true;
        } else if ($row['password'] === $check) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
            return;
        } else {
            $error = "🔒 Incorrect password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🔐 Login Portal</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6d365, #fda085);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box h1 {
            color: #333;
            margin-bottom: 25px;
            font-size: 28px;
        }

        .login-box input[type="email"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }

        .login-box input[type="email"]:focus,
        .login-box input[type="password"]:focus {
            border-color: #fda085;
            outline: none;
            box-shadow: 0 0 5px rgba(253, 160, 133, 0.5);
        }

        .login-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #ff6f61;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-box input[type="submit"]:hover {
            background-color: #e85c50;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .register-link {
            margin-top: 20px;
            font-size: 15px;
        }

        .register-link a {
            color: #0078D7;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function validateForm() {
            var email = document.getElementById('email').value.trim();
            var pass = document.getElementById('pass').value.trim();
            if (email === "" && pass === "") {
                alert("⚠️ Both fields are required");
                return false;
            }
            if (email === "") {
                alert("📧 Email is required");
                return false;
            }
            if (pass === "") {
                alert("🔒 Password is required");
                return false;
            }
            if (email.indexOf('@') === -1) {
                alert("📧 Email address must contain @");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="login-box">
        <h1>👋 Welcome<?php if (isset($_SESSION['name'])) echo ", " . htmlentities($_SESSION['name']); ?>!</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlentities($error) ?></div>
        <?php endif; ?>

        <form method="post" onsubmit="return validateForm();">
            <input type="email" name="email" id="email" placeholder="📧 Email">
            <input type="password" name="pass" id="pass" placeholder="🔒 Password">
            <input type="submit" value="🚪 Log In">
        </form>

        <div class="register-link">
            <p>🆕 New user? <a href="register.php">Register Here</a></p>
        </div>
    </div>
</body>
</html>
