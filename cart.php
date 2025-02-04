<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    header('Location: /cart.php');
    exit;
}

if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user']['id'];
    $total = 0;

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        $total += $product['price'] * $quantity;
    }

    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    $order_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);
    }

    unset($_SESSION['cart']);
    header('Location: /orders.php');
    exit;
}

$cart_items = [];
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        $product['quantity'] = $quantity;
        $cart_items[] = $product;
    }
}
?>

<main>
    <h1>Корзина</h1>
    <?php if (empty($cart_items)): ?>
        <p>Ваша корзина пуста.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Итого</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['price'] ?> руб.</td>
                        <td><?= $item['price'] * $item['quantity'] ?> руб.</td>
                        <td><a href="?remove=<?= $item['id'] ?>">Удалить</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="POST">
            <button type="submit" name="checkout">Оформить заказ</button>
        </form>
    <?php endif; ?>
</main>

<?php require 'includes/footer.php'; ?>