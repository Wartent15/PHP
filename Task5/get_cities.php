<?php
include_once('db.php');

if (isset($_GET['countryid'])) {
    $id = intval($_GET['countryid']);
    $pdo = connect();
    
    // Используем подготовленный запрос для безопасности
    $ps = $pdo->prepare("SELECT city FROM Cities WHERE countryid = ?");
    $ps->execute([$id]);
    
    if ($ps->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>Список городов</th></tr>";
        while ($row = $ps->fetch()) {
            echo "<tr><td>" . htmlspecialchars($row['city']) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Города для этой страны не найдены.</p>";
    }
}
