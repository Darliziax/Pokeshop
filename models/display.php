<?php
class Display {
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $stock;
    private string $image_url;

    public function __construct(int $id, string $name, string $description, float $price, int $stock, string $image_url) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->setStock($stock); 
        $this->image_url = $image_url;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function getImageUrl(): string {
        return $this->image_url;
    }

    public function setStock(int $stock): void {
        if ($stock < 0) {
            throw new InvalidArgumentException("Le stock ne peut pas être négatif.");
        }
        $this->stock = $stock;
    }

    public function addStock(int $quantity): void {
        if ($quantity < 0) {
            throw new InvalidArgumentException("La quantité ajoutée doit être positive.");
        }
        $this->stock += $quantity;
    }

    public function removeStock(int $quantity): void {
        if ($quantity < 0) {
            throw new InvalidArgumentException("La quantité retirée doit être positive.");
        }
        if ($this->stock < $quantity) {
            throw new RuntimeException("Stock insuffisant pour retirer cette quantité.");
        }
        $this->stock -= $quantity;
    }
}
?>
