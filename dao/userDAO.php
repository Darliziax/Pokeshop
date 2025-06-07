<?php
require_once __DIR__ . '/../models/user.php';

class UserDAO {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les utilisateurs.
     */
    public function getAllUsers(): array {
        $stmt = $this->pdo->query("SELECT * FROM clients");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($data) => new User(
            $data['clients_id'],
            $data['username'],
            $data['email'],
            $data['password']
        ), $results);
    }

    /**
     * Supprime un utilisateur par son ID.
     */
    public function deleteUserById(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM clients WHERE clients_id = ?");
        return $stmt->execute([$id]);
    }

}
