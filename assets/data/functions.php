<?php
// assets/data/functions.php
// Small helpers used by controllers/views

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function flash_set($key, $message) {
    if (!session_id()) session_start();
    $_SESSION['flash'][$key] = $message;
}

function flash_get($key) {
    if (!session_id()) session_start();
    if (!empty($_SESSION['flash'][$key])) {
        $m = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $m;
    }
    return null;
}

// simple redirect helper
function redirect($url) {
    header("Location: $url");
    exit;
}
