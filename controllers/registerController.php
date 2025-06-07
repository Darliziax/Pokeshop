<?php
require_once __DIR__ . '/../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Vérification de champs vides
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        header('Location: ../auth/register.php?error=empty_fields');
        exit;
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../auth/register.php?error=invalid_email');
        exit;
    }

    // Vérification de la correspondance des mots de passe
    if ($password !== $confirm) {
        header('Location: ../auth/register.php?error=password_mismatch');
        exit;
    }

    $db = new Database();
    $pdo = $db->getPdo();

    // Vérification de l'unicité de l'email
    $stmt = $pdo->prepare("SELECT clients_id FROM clients WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header('Location: ../auth/register.php?error=email_exists');
        exit;
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion en base
    $stmt = $pdo->prepare("INSERT INTO clients (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    // Connexion automatique après inscription
    $_SESSION['clients_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;

    header('Location: ../index.php');
    exit;
}
?>
