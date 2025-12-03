<?php
// index.php - front controller
$page = $_GET['page'] ?? 'client';

if ($page === 'admin') {
    require_once __DIR__ . '/controllers/admin.php';
} else {
    require_once __DIR__ . '/controllers/client.php';
}
