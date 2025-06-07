<?php
session_start();
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/css/register.css" />
</head>
<body>

    <div class="register-container">
        <h2>Inscription</h2>

        <?php if ($error === 'exists'): ?>
            <p class="error-message">Cet email est déjà utilisé.</p>
        <?php elseif ($error === 'invalid'): ?>
            <p class="error-message">Veuillez remplir tous les champs correctement.</p>
        <?php elseif ($error === 'password_mismatch'): ?>
            <p class="error-message">Les mots de passe ne correspondent pas.</p>
        <?php endif; ?>

        <form method="post" action="../controllers/registerController.php">
            <input type="text" name="username" required placeholder="Nom d'utilisateur" />
            <input type="email" name="email" required placeholder="Email" />
            <input type="password" name="password" required placeholder="Mot de passe" />
            <input type="password" name="confirm_password" required placeholder="Confirmez le mot de passe">
            <button type="submit">S'inscrire</button>
        </form>
        
        <p class="register-link">Déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
    </div>

</body>
</html>
