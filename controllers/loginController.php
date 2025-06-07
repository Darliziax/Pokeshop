<?php
require_once __DIR__ . '/../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Connexion en tant qu'admin 
    if (strcasecmp($username, 'Admin') === 0 && strcasecmp($password, 'Admin') === 0) {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_username'] = 'Admin';
        header('Location: ../admin/dashboard.php');
        exit;
    }

    // Connexion à la base
    $db = new Database();
    $pdo = $db->getPdo();

    // Vérification de l'existence du client
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['clients_id'] = $user['clients_id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../index.php');
        exit;
    }

    // Échec de la connexion
    header('Location: ../auth/login.php?error=invalid');
    exit;
}
?>
