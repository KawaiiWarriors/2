<?php
require 'includes/db.php';
require 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        header('Location: /');
        exit;
    } else {
        $error = "Неверное имя пользователя или пароль.";
    }
}
?>

<main>
    <h1>Авторизация</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</main>

<?php require 'includes/footer.php'; ?>