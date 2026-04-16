<?php
function connect() {
    $host = 'localhost';
    $db = 'your_database_name'; // Укажите имя вашей базы
    $user = 'root';
    $pass = '';
    return new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
}
?>
