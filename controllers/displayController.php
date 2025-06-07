<?php
// Démarrage de la session utilisateur
session_start();

// Inclusion du fichier de configuration de la base de données
require_once __DIR__ . '/../config/database.php';

// Inclusion du DAO pour les objets "display"
require_once __DIR__ . '/../dao/displayDAO.php';

// Connexion à la base via la classe Database
$db = new Database();
$pdo = $db->getPdo();

// Instanciation du DAO
$displayDAO = new displayDAO($pdo);

// Récupération de tous les displays en base
$displays = $displayDAO->getAllDisplays();
?>
