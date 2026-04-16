<?php
class User {
    // Свойства класса
    public $login;
    public $pass;
    public $email;

    // Конструктор с параметрами
    public function __construct($login, $pass, $email) {
        $this->login = $login;
        $this->pass = $pass;
        $this->email = $email;
    }

    // Метод для отображения данных
    public function show() {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin-top: 20px; border-radius: 5px; background: #f9f9f9;'>";
        echo "<h3>Данные нового пользователя:</h3>";
        echo "<p><strong>Логин:</strong> " . htmlspecialchars($this->login) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($this->email) . "</p>";
        echo "<p><strong>Хэш пароля:</strong> " . $this->pass . "</p>";
        echo "</div>";
    }
}
