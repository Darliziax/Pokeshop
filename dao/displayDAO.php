<?php
require_once __DIR__ . '/../models/display.php';

class DisplayDAO {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les displays
    public function getAllDisplays(): array {
        $stmt = $this->pdo->query("SELECT * FROM displays ORDER BY price DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $displays = [];
        foreach ($rows as $row) {
            $displays[] = new Display(
                (int) $row['display_id'],
                $row['name'],
                $row['description'],
                (float) $row['price'],
                (int) $row['stock'],
                $row['image_url']
            );
        }
        return $displays;
    }

    // Récupérer un display par ID
    public function getById(int $id): ?Display {
        $stmt = $this->pdo->prepare("SELECT * FROM displays WHERE display_id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Display(
                (int) $row['display_id'],
                $row['name'],
                $row['description'],
                (float) $row['price'],
                (int) $row['stock'],
                $row['image_url']
            );
        }

        return null;
    }

    // Ajouter un nouveau display
    public function addDisplay(Display $display): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO displays (name, description, price, stock, image_url) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $display->getName(),
            $display->getDescription(),
            $display->getPrice(),
            $display->getStock(),
            $display->getImageUrl()
        ]);
    }

    // Modifier un display existant
    public function updateDisplay(Display $display): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE displays SET name = ?, description = ?, price = ?, stock = ?, image_url = ? WHERE display_id = ?"
        );
        return $stmt->execute([
            $display->getName(),
            $display->getDescription(),
            $display->getPrice(),
            $display->getStock(),
            $display->getImageUrl(),
            $display->getId()
        ]);
    }

    // Supprimer un display
    public function deleteDisplayById(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM displays WHERE display_id = ?");
        return $stmt->execute([$id]);
    }

    // Diminuer le stock
    public function decreaseStock(int $id, int $quantity): bool {
        $display = $this->getById($id);
        if (!$display) return false;

        try {
            $display->removeStock($quantity);
        } catch (Exception $e) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE displays SET stock = ? WHERE display_id = ?");
        return $stmt->execute([$display->getStock(), $id]);
    }

    // Augmenter le stock (optionnel)
    public function increaseStock(int $id, int $quantity): bool {
        $display = $this->getById($id);
        if (!$display) return false;

        try {
            $display->addStock($quantity);
        } catch (Exception $e) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE displays SET stock = ? WHERE display_id = ?");
        return $stmt->execute([$display->getStock(), $id]);
    }
}
?>
