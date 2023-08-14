<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "webproject";

try {
    $pdo = new PDO("mysql:host=$servername; port=3307; dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
