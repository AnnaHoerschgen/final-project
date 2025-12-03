<?php
// models/Admin.php
class AdminModel {
    private $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE username = :u");
        $stmt->execute([':u'=>$username]);
        return $stmt->fetch();
    }
}
