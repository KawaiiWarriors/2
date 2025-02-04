<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<main>
    <h1>Мои заказы</h1>
    <?php if (empty($orders)): ?>
        <p>У вас нет заказов.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Номер заказа</th>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Детали</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['created_at'] ?></td>
                        <td><?= $order['total'] ?> руб.</td>
                        <td><?= $order['status'] ?></td>
                        <td><a href="order_details.php?id=<?= $order['id'] ?>">Просмотреть</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require 'includes/footer.php'; ?>