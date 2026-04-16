<?php
include('includes/db.php');

// Параметры подключения (замените на свои)
$pdo = connect('localhost', 'root', '', 'my_database');
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    if (!empty($login) && !empty($email) && !empty($_POST['password'])) {
        try {
            // Подготовленный запрос для вставки
            $sql = "INSERT INTO users (login, password, email) VALUES (:login, :password, :email)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'login' => $login,
                'password' => $pass,
                'email' => $email
            ]);
            $message = "<p style='color:green;'>Регистрация прошла успешно!</p>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "<p style='color:red;'>Ошибка: Логин '$login' уже занят.</p>";
            } else {
                $message = "<p style='color:red;'>Произошла ошибка: " . $e->getMessage() . "</p>";
            }
        }
    } else {
        $message = "<p style='color:orange;'>Пожалуйста, заполните все поля.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h2>Форма регистрации</h2>
    <?= $message ?>
    <form method="POST">
        <input type="text" name="login" placeholder="Логин" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Пароль" required><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
