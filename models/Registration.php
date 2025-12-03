<?php
// models/Registration.php
class RegistrationModel {
    private $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function createRegistration($event_id, $name, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO registrations (event_id, name, email) VALUES (:eid, :name, :email)");
        return $stmt->execute([':eid'=>$event_id, ':name'=>$name, ':email'=>$email]);
    }

    public function getRegistrationsGroupedByEvent() {
        $stmt = $this->pdo->prepare("
            SELECT r.*, e.title, e.event_date
            FROM registrations r
            JOIN events e ON e.id = r.event_id
            ORDER BY e.event_date DESC, r.registered_at ASC
        ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $grouped = [];
        foreach ($rows as $r) {
            $key = $r['event_id'];
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'event_title' => $r['title'],
                    'event_date' => $r['event_date'],
                    'registrations' => []
                ];
            }
            $grouped[$key]['registrations'][] = $r;
        }
        return $grouped;
    }

    public function getRegistrationsForEvent($event_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE event_id = :eid ORDER BY registered_at ASC");
        $stmt->execute([':eid'=>$event_id]);
        return $stmt->fetchAll();
    }
}
