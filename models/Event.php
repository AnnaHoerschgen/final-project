<?php
// models/Event.php
class EventModel {
    private $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getUpcomingEvents() {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE event_date >= NOW() ORDER BY event_date ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEventById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function createEvent($title, $date, $location, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO events (title, event_date, location, description) VALUES (:title, :date, :location, :description)");
        $stmt->execute([
            ':title'=>$title, ':date'=>$date, ':location'=>$location, ':description'=>$description
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateEvent($id, $title, $date, $location, $description) {
        $stmt = $this->pdo->prepare("UPDATE events SET title = :title, event_date = :date, location = :location, description = :description WHERE id = :id");
        return $stmt->execute([
            ':title'=>$title, ':date'=>$date, ':location'=>$location, ':description'=>$description, ':id'=>$id
        ]);
    }

    public function deleteEvent($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id = :id");
        return $stmt->execute([':id'=>$id]);
    }

    public function getAllEvents() {
        $stmt = $this->pdo->prepare("SELECT * FROM events ORDER BY event_date DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
