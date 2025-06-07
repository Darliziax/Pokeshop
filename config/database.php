<?php
class Database {
    // Informations de connexion
    private string $host = "localhost";
    private string $port = "5432";
    private string $dbname = "pokeshop";
    private string $user = "postgres";
    private string $password = "prout"; 

    private ?PDO $pdo = null;

    public function __construct() {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";

        try {
            // Connexion à la base PostgreSQL
            $this->pdo = new PDO($dsn, $this->user, $this->password);

            // Activation des erreurs PDO en exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Encodage UTF-8 (utile si problèmes d’accents)
            $this->pdo->exec("SET NAMES 'UTF8'");
        } catch (PDOException $e) {
            // Affiche une erreur en cas d’échec de connexion
            die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
        }
    }

    // Accesseur pour récupérer l’objet PDO
    public function getPdo(): PDO {
        return $this->pdo;
    }
}
?>
