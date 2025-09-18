<?php
try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=resume', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected to the database successfully.";
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}
?>
