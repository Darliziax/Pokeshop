<?php
session_start();
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>

    <div class="register-container"> <!-- On garde la même classe que pour register.php -->
        <h2>Connexion</h2>

        <?php if ($error === 'invalid'): ?>
            <p class="error-message">Identifiants invalides.</p>
        <?php endif; ?>

        <form method="post" action="../controllers/loginController.php" novalidate>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required placeholder="Nom d'utilisateur" />

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required placeholder="Mot de passe" />

            <button type="submit">Se connecter</button>
        </form>

        <p class="register-link">
            Pas encore de compte ?
            <a href="register.php">Inscrivez-vous ici</a>
        </p>
    </div>

</body>
</html>
