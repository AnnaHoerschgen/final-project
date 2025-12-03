<?php
// assets/data/db.php
// Single PDO connection - include where needed.

$DB_HOST = 'localhost';
$DB_NAME = 'event_planner';
$DB_USER = 'root';
$DB_PASS = ''; // <- set your DB password here

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    // For security, avoid echoing details in production
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
