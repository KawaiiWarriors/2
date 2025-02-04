<?php
session_start();
require '../includes/db.php';
require '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /');
    exit;
}
?>

<main>
    <h1>Админ-панель</h1>
    <nav>
        <a href="products.php">Управление товарами</a>
        <a href="orders.php">Управление заказами</a>
    </nav>
</main>

<?php require '../includes/footer.php'; ?>