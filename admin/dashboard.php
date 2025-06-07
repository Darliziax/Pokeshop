<?php
// Démarre la session PHP
session_start();

// Inclusion des fichiers nécessaires à la connexion à la base et à la gestion des données
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/userDAO.php';
require_once __DIR__ . '/../dao/displayDAO.php';
require_once __DIR__ . '/../models/Display.php';
require_once __DIR__ . '/../models/User.php';

// Vérifie si l'admin est connecté ; sinon redirige vers la page de login
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Initialisation de la connexion à la base de données et des DAO
$db = new Database();
$pdo = $db->getPdo();
$userDao = new UserDao($pdo);
$displayDao = new DisplayDAO($pdo);

// Traitement des actions envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Suppression d'un client
    if (isset($_POST['clients_id'])) {
        $userDao->deleteUserById((int)$_POST['clients_id']);
        header('Location: dashboard.php');
        exit;
    }

    // Suppression d'un display
    if (isset($_POST['delete_display_id'])) {
        $displayDao->deleteDisplayById((int)$_POST['delete_display_id']);
        header('Location: dashboard.php');
        exit;
    }

    // Modification d'un display existant
    if (isset($_POST['update_display_id'])) {
        $display = new Display(
            (int)$_POST['update_display_id'],
            trim($_POST['name']),
            trim($_POST['description']),
            (float)$_POST['price'],
            (int)$_POST['stock'],
            trim($_POST['image_url'])
        );
        $displayDao->updateDisplay($display);
        header('Location: dashboard.php');
        exit;
    }

    // Ajout d’un nouveau display
    if (isset($_POST['add_display'])) {
        $display = new Display(
            0, // ID à 0 pour indiquer un nouvel enregistrement
            trim($_POST['name']),
            trim($_POST['description']),
            (float)$_POST['price'],
            (int)$_POST['stock'],
            trim($_POST['image_url'])
        );
        $displayDao->addDisplay($display);
        header('Location: dashboard.php');
        exit;
    }
}

// Récupération des données à afficher
$clients = $userDao->getAllUsers();        // Liste des utilisateurs (objets User)
$displays = $displayDao->getAllDisplays(); // Liste des produits (objets Display)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<!-- Message de bienvenue avec nom d'utilisateur stocké en session -->
<h1>Bienvenue, <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>
<p><a href="../auth/logout.php">Déconnexion</a></p>

<!-- Table des clients -->
<h2>Clients</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client->getUsername()) ?></td>
                <td>
                    <!-- Formulaire pour supprimer un client -->
                    <form method="post" style="margin:0;">
                        <input type="hidden" name="clients_id" value="<?= $client->getId() ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Gestion des produits (Displays) -->
<h2>Gestion des Displays</h2>
<table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Image URL</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Ligne pour ajouter un nouveau display -->
        <tr>
            <form method="post">
                <td><input type="text" name="name" required></td>
                <td><textarea name="description" required></textarea></td>
                <td><input type="number" name="price" step="0.01" min="0" required></td>
                <td><input type="number" name="stock" min="0" required></td>
                <td><input type="text" name="image_url" required></td>
                <td>
                    <input type="hidden" name="add_display" value="1" />
                    <button type="submit">Ajouter</button>
                </td>
            </form>
        </tr>

        <!-- Affichage de tous les displays avec possibilité de modifier ou supprimer -->
        <?php foreach ($displays as $display): ?>
            <tr>
                <!-- Formulaire de modification -->
                <form method="post">
                    <td><input type="text" name="name" value="<?= htmlspecialchars($display->getName()) ?>" required></td>
                    <td><textarea name="description" required><?= htmlspecialchars($display->getDescription()) ?></textarea></td>
                    <td><input type="number" name="price" step="0.01" min="0" value="<?= $display->getPrice() ?>" required></td>
                    <td><input type="number" name="stock" min="0" value="<?= $display->getStock() ?>" required></td>
                    <td><input type="text" name="image_url" value="<?= htmlspecialchars($display->getImageUrl()) ?>" required></td>
                    <td>
                        <input type="hidden" name="update_display_id" value="<?= $display->getId() ?>">
                        <button type="submit">Modifier</button>
                </form>

                <!-- Formulaire de suppression -->
                <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_display_id" value="<?= $display->getId() ?>">
                    <button type="submit" onclick="return confirm('Supprimer ce display ?')">Supprimer</button>
                </form>
                    </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
