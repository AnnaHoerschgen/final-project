<?php
if (!session_id()) session_start();
require_once __DIR__ . '/../../assets/data/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Event Planner</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="assets/stylesheets/styles.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1><a href="index.php" style="text-decoration:none;color:inherit">Event Planner</a></h1>
      <nav>
        <a href="index.php">Events</a>
        <?php if (!empty($_SESSION['admin_logged_in'])): ?>
          <a href="index.php?page=admin&action=dashboard" class="button">Admin</a>
          <a href="index.php?page=admin&action=logout" class="button button-secondary">Logout</a>
        <?php else: ?>
          <a href="index.php?page=admin&action=login" class="button">Admin Login</a>
        <?php endif; ?>
      </nav>
    </div>

    <?php if ($msg = flash_get('success')): ?>
      <div class="alert"><?= e($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = flash_get('error')): ?>
      <div class="error"><?= e($msg) ?></div>
    <?php endif; ?>
