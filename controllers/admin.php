<?php
// controllers/admin.php
require_once __DIR__ . '/../assets/data/db.php';
require_once __DIR__ . '/../assets/data/functions.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Registration.php';

session_start();

$adminModel = new AdminModel($pdo);
$eventModel = new EventModel($pdo);
$regModel = new RegistrationModel($pdo);

$action = $_GET['action'] ?? 'dashboard';

// guard helper
function require_admin() {
    if (empty($_SESSION['admin_logged_in'])) {
        redirect('index.php?page=admin&action=login');
    }
}

if ($action === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $admin = $adminModel->getByUsername($username);
        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            redirect('index.php?page=admin&action=dashboard');
        } else {
            $error = "Invalid credentials.";
        }
    }
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/admin_login.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

if ($action === 'logout') {
    session_destroy();
    redirect('index.php');
}

if ($action === 'dashboard') {
    require_admin();
    $events = $eventModel->getAllEvents();
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/admin_dashboard.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

if ($action === 'event_form') {
    require_admin();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $event = $id ? $eventModel->getEventById($id) : null;
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/admin_event_form.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

if ($action === 'save_event' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_admin();
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = trim($_POST['title'] ?? '');
    $date = trim($_POST['event_date'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $errors = [];

    if ($title === '') $errors[] = "Title is required.";
    if ($date === '') $errors[] = "Date/time is required.";
    if ($location === '') $errors[] = "Location is required.";
    if ($description === '') $errors[] = "Description is required.";

    // attempt to parse date into MySQL DATETIME - assume incoming is 'YYYY-MM-DDTHH:MM' for html datetime-local
    $date_formatted = $date;
    if (strpos($date, 'T') !== false) {
        $date_formatted = str_replace('T', ' ', $date) . ':00';
    }

    if (empty($errors)) {
        if ($id) {
            $eventModel->updateEvent($id, $title, $date_formatted, $location, $description);
            flash_set('success', 'Event updated.');
        } else {
            $eventModel->createEvent($title, $date_formatted, $location, $description);
            flash_set('success', 'Event created.');
        }
        redirect('index.php?page=admin&action=dashboard');
    } else {
        // re-show form with errors
        $event = ['id'=>$id, 'title'=>$title, 'event_date'=>$date_formatted, 'location'=>$location, 'description'=>$description];
        include __DIR__ . '/../view-stuffs/partials/header.php';
        include __DIR__ . '/../view-stuffs/views/admin_event_form.php';
        include __DIR__ . '/../view-stuffs/partials/footer.php';
        exit;
    }
}

if ($action === 'delete_event' && isset($_GET['id'])) {
    require_admin();
    $id = (int)$_GET['id'];
    $eventModel->deleteEvent($id);
    flash_set('success', 'Event deleted.');
    redirect('index.php?page=admin&action=dashboard');
}

if ($action === 'registrations') {
    require_admin();
    $grouped = $regModel->getRegistrationsGroupedByEvent();
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/admin_registrations.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

// default redirect
redirect('index.php');
