<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$order_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: /orders.php');
    exit;
}

$stmt = $pdo->prepare("SELECT oi.quantity, oi.price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>

<main>
    <h1>Детали заказа #<?= $order['id'] ?></h1>
    <p>Дата: <?= $order['created_at'] ?></p>
    <p>Статус: <?= $order['status'] ?></p>
    <p>Общая сумма: <?= $order['total'] ?> руб.</p>

    <h2>Товары:</h2>
    <table>
        <thead>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Итого</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['price'] ?> руб.</td>
                    <td><?= $item['price'] * $item['quantity'] ?> руб.</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require 'includes/footer.php'; ?>