<?php
session_start();
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['clients_id'])) {
    header('Location: auth/login.php');
    exit;
}

$action = $_GET['action'] ?? null;
$cart = $_SESSION['cart'] ?? [];

$db = new Database();
$pdo = $db->getPdo();

// Supprimer un produit (ou diminuer sa quantité)
if ($action === 'remove' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['display_id'])) {
    $display_id = (int)$_POST['display_id'];
    if (isset($_SESSION['cart'][$display_id])) {
        $_SESSION['cart'][$display_id]--;
        if ($_SESSION['cart'][$display_id] <= 0) {
            unset($_SESSION['cart'][$display_id]);
        }
    }
    header('Location: purchase.php');
    exit;
}

// Ajouter un produit
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['display_id'])) {
    $display_id = (int)$_POST['display_id'];
    $_SESSION['cart'][$display_id] = ($_SESSION['cart'][$display_id] ?? 0) + 1;
    header('Location: purchase.php');
    exit;
}

// Paiement
if ($action === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($cart)) {
        header('Location: purchase.php');
        exit;
    }

    try {
        $pdo->beginTransaction();

        foreach ($cart as $display_id => $qty) {
            $stmt = $pdo->prepare("SELECT stock FROM displays WHERE display_id = ?");
            $stmt->execute([$display_id]);
            $stock = $stmt->fetchColumn();

            if ($stock < $qty) {
                throw new Exception("Stock insuffisant pour le produit $display_id");
            }

            $stmt = $pdo->prepare("UPDATE displays SET stock = stock - ? WHERE display_id = ?");
            $stmt->execute([$qty, $display_id]);
        }

        // Option : enregistrement de la commande ici

        $pdo->commit();
        unset($_SESSION['cart']);
        $message = "Paiement effectué avec succès. Merci pour votre achat !";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Erreur lors du paiement : " . htmlspecialchars($e->getMessage());
    }
}

// Récupération des produits du panier
$items = [];
if (!empty($cart)) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM displays WHERE display_id IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $items = $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Panier / Achat - Pokeshop</title>
    <link rel="stylesheet" href="assets/css/purchase.css" />
</head>
<body>

    <h1>Votre panier</h1>

    <?php if (!empty($message)): ?>
        <p class="message"><?= $message ?></p>
        <p><a class="btn-back" href="index.php">Retour à l'accueil</a></p>
    <?php elseif (empty($items)): ?>
        <p class="message">Votre panier est vide.</p>
        <p><a class="btn-back" href="index.php">Continuer vos achats</a></p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                foreach ($items as $item):
                    $qty = $cart[$item->display_id];
                    $lineTotal = $item->price * $qty;
                    $totalPrice += $lineTotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item->name) ?></td>
                        <td><?= $qty ?></td>
                        <td><?= number_format($item->price, 2) ?> €</td>
                        <td><?= number_format($lineTotal, 2) ?> €</td>
                        <td class="actions-td">
                            <form action="purchase.php?action=remove" method="POST" class="inline-form">
                                <input type="hidden" name="display_id" value="<?= $item->display_id ?>">
                                <button class="btn-action" type="submit">−</button>
                            </form>
                            <form action="purchase.php?action=add" method="POST" class="inline-form">
                                <input type="hidden" name="display_id" value="<?= $item->display_id ?>">
                                <button class="btn-action" type="submit">+</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="total-price"><strong>Total à payer : <?= number_format($totalPrice, 2) ?> €</strong></p>

        <form action="purchase.php?action=checkout" method="POST" class="checkout-form">
            <button class="btn-checkout" type="submit">Payer</button>
        </form>
        <p><a class="btn-back" href="index.php">Continuer vos achats</a></p>
    <?php endif; ?>

</body>
</html>
