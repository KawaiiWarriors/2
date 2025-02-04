<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header('Location: /catalog.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<main>
    <h1>Каталог товаров</h1>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <?php if ($product['image']): ?>
                    <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width: 100px;">
                <?php endif; ?>
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p>Цена: <?= $product['price'] ?> руб.</p>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                    <button type="submit" name="add_to_cart">Добавить в корзину</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require 'includes/footer.php'; ?>