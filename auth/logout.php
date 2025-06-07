<?php
// Démarre ou reprend la session actuelle
session_start();

// Supprime toutes les données de session
session_destroy();

// Redirige l'utilisateur vers la page d'accueil
header("Location: ../index.php");
exit;
?>
