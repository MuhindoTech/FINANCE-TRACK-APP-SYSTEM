<?php
// config.php

$host = 'localhost';  // Change this if using a different host
$db = 'finance_tracker';
$user = 'root';       // Change this if you have a custom username
$pass = '';           // Change this if you have a password

// Set DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db";

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Enable error reporting
} catch (PDOException $e) {
    // Handle error if connection fails
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>
