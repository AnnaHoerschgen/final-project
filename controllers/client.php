<?php
// controllers/client.php
require_once __DIR__ . '/../assets/data/db.php';
require_once __DIR__ . '/../assets/data/functions.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Registration.php';

$eventModel = new EventModel($pdo);
$regModel = new RegistrationModel($pdo);

// route by action parameter
$action = $_GET['action'] ?? 'list';

if ($action === 'list') {
    $events = $eventModel->getUpcomingEvents();
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/public_event.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

if ($action === 'detail') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $event = $eventModel->getEventById($id);
    if (!$event) {
        flash_set('error', 'Event not found.');
        redirect('index.php');
    }
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/public_events.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $event_id = (int)($_POST['event_id'] ?? 0);
    $errors = [];

    if ($name === '') $errors[] = "Name is required.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if ($event_id <= 0) $errors[] = "Invalid event.";

    $event = $eventModel->getEventById($event_id);
    if (!$event) $errors[] = "Event not found.";

    if (!$errors) {
        $ok = $regModel->createRegistration($event_id, $name, $email);
        if ($ok) {
            include __DIR__ . '/../view-stuffs/partials/header.php';
            $registered_name = $name;
            $registered_event = $event;
            include __DIR__ . '/../view-stuffs/views/public_confirm.php';
            include __DIR__ . '/../view-stuffs/partials/footer.php';
            exit;
        } else {
            $errors[] = "Database error saving registration.";
        }
    }

    // show form with errors
    include __DIR__ . '/../view-stuffs/partials/header.php';
    include __DIR__ . '/../view-stuffs/views/public_events.php';
    include __DIR__ . '/../view-stuffs/partials/footer.php';
    exit;
}

// default
redirect('index.php');
