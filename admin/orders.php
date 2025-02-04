<?php
session_start();
require '../includes/db.php';
require '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
    header('Location: orders.php');
    exit;
}

if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    header('Location: orders.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>

<main>
    <h1>Управление заказами</h1>
    <nav>
        <a href="products.php">Управление товарами</a>
        <a href="orders.php">Управление заказами</a>
    </nav>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_id'] ?></td>
                    <td><?= $order['total'] ?> руб.</td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Ожидание</option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>В обработке</option>
                                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Завершен</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Отменен</option>
                            </select>
                            <button type="submit" name="update_status">Обновить</button>
                        </form>
                    </td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <a href="?delete=<?= $order['id'] ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require '../includes/footer.php'; ?>