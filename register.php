<?php
require 'includes/db.php';
require 'includes/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $error = "Пользователь с таким именем или email уже существует.";
    } else {
        registerUser($username, $password, $email);
        header('Location: /login.php');
        exit;
    }
}
?>

<main>
    <h1>Регистрация</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</main>

<?php require 'includes/footer.php'; ?>