<?php
// config/db.php

$host = 'localhost';
$user = 'root';
$password = ''; // Default laragon password
$dbname = 'nextgenz';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Graceful error for UI
    die("Database connection failed. Please ensure the database is initialized.");
}
?>