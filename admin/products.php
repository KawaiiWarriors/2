<?php
session_start();
require '../includes/db.php';
require '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $uploadFile]);
            header('Location: products.php');
            exit;
        } else {
            $error = "Ошибка при загрузке изображения.";
        }
    } else {
        $error = "Изображение не загружено.";
    }
}

if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];

    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product['image'] && file_exists($product['image'])) {
        unlink($product['image']);
    }

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    header('Location: products.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<main>
    <h1>Управление товарами</h1>
    <nav>
        <a href="products.php">Управление товарами</a>
        <a href="orders.php">Управление заказами</a>
    </nav>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Название" required>
        <textarea name="description" placeholder="Описание" required></textarea>
        <input type="number" name="price" placeholder="Цена" step="0.01" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="add_product">Добавить товар</button>
    </form>

    <h2>Список товаров</h2>
    <table style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= $product['price'] ?> руб.</td>
                    <td>
                        <a href="?delete=<?= $product['id'] ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require '../includes/footer.php'; ?>