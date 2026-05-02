<?php

class MyModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAllRecordsModel() {
        $stmt = $this->db->query("SELECT * FROM Pictures");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class MyController {
    private $model;

    public function __construct(MyModel $model) {
        $this->model = $model;
    }

    public function getAllRecords() {
        return $this->model->getAllRecordsModel();
    }
}

try {
    $host = 'localhost';
    $db   = 'test_db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Создаем объекты
    $model = new MyModel($pdo);
    $controller = new MyController($model); // Внедряем зависимость

    $records = [];

    // Проверяем, была ли нажата ссылка/кнопка
    if (isset($_GET['action']) && $_GET['action'] === 'show_all') {
        $records = $controller->getAllRecords();
    }

} catch (PDOException $e) {
    $error_message = "Ошибка БД: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Simplified MVC DI</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        table { margin-top: 20px; border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid #ccc; padding: 10px; }
    </style>
</head>
<body>

    <h1>Моя MVC страница</h1>

    <!-- Кнопка (ссылка), которая активирует контроллер -->
    <a href="?action=show_all" class="btn">All Records</a>

    <hr>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (!empty($records)): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($records[0]) as $column): ?>
                        <th><?php echo htmlspecialchars($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_GET['action'])): ?>
        <p>Записей не найдено или таблица пуста.</p>
    <?php endif; ?>

</body>
</html>
