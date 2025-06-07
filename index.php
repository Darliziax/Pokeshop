<?php
// Contrôleur principal pour récupérer les produits (Displays)
require_once __DIR__ . '/controllers/displayController.php';

// Démarrage de session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Pokeshop</title>
    <link rel="stylesheet" href="assets/css/index.css" />
</head>
<body>

<!-- Barre de navigation en haut de page -->
<header class="top-nav">
    <nav class="nav-left">
        <?php if (isset($_SESSION['clients_id'])): ?>
            <!-- Affichage du nom d'utilisateur connecté -->
            <p>
                Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> -
                <a href="auth/logout.php">Se déconnecter</a>
            </p>
        <?php else: ?>
            <!-- Lien vers connexion/inscription -->
            <p>
                <a href="auth/login.php">Connexion</a> | <a href="auth/register.php">Inscription</a>
            </p>
        <?php endif; ?>
    </nav>

    <nav class="nav-right">
        <?php if (isset($_SESSION['clients_id'])): ?>
            <!-- Lien vers le panier (visible uniquement pour clients connectés) -->
            <a href="purchase.php" class="cart-link">Voir mon panier</a>
        <?php endif; ?>
    </nav>
</header>

<!-- Titre principal -->
<h1 class="site-title">Bienvenue sur Pokeshop</h1>

<!-- Liste des produits disponibles -->
<main class="products-container">
    <?php foreach ($displays as $display): ?>
        <div class="product">
            <h2><?= htmlspecialchars($display->getName()) ?></h2>
            <p><?= htmlspecialchars($display->getDescription()) ?></p>
            <p>Prix : <?= number_format($display->getPrice(), 2) ?> €</p>
            <p>Stock : <?= (int)$display->getStock() ?></p>
            <img src="<?= htmlspecialchars($display->getImageUrl()) ?>" alt="<?= htmlspecialchars($display->getName()) ?>" />

            <?php if (isset($_SESSION['clients_id'])): ?>
                <!-- Formulaire d'ajout au panier -->
                <form action="controllers/purchaseController.php?action=add" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="display_id" value="<?= $display->getId() ?>">
                    <button type="submit">Ajouter au panier</button>
                </form>
            <?php else: ?>
                <!-- Message pour utilisateur non connecté -->
                <p class="login-prompt">
                    <a href="auth/login.php">Connectez-vous pour acheter.</a>
                </p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</main>

</body>
</html>
