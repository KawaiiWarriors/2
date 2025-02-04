<?php include 'auth.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хамелеон - Зоомагазин</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo">Хамелеон</div>
        <nav>
            <a href="/">Главная</a>
            <a href="/catalog.php">Каталог</a>
            <a href="/cart.php">Корзина</a>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'user' || 'admin'): ?>
                <a href="/orders.php">Мои заказы</a>
                <a href="/logout.php">Выйти</a>
            <?php else: ?>
                <a href="/login.php">Войти</a>
                <a href="/register.php">Регистрация</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'): ?>
                <a href="/admin/index.php">Админ-панель</a>
            <?php endif; ?>    
        </nav>
    </header>