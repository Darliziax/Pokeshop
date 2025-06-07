<?php
session_start();

// Redirige vers login si l'utilisateur n'est pas connecté
if (!isset($_SESSION['clients_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$action = $_GET['action'] ?? null;

// Ajout d'un produit au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add' && isset($_POST['display_id'])) {
    $display_id = (int) $_POST['display_id'];

    // Initialiser le panier s'il n'existe pas encore
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Ajouter 1 au produit existant ou l'initialiser à 1
    if (isset($_SESSION['cart'][$display_id])) {
        $_SESSION['cart'][$display_id]++;
    } else {
        $_SESSION['cart'][$display_id] = 1;
    }

    // Redirection vers la page d'accueil
    header('Location: ../index.php');
    exit;
}


header('Location: ../index.php');
exit;
