<?php include_once('db.php'); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Выбор города</title>
    <style>
        table { width: 300px; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <h2>Выберите страну:</h2>
    <select id="countrySelect" onchange="showCities(this.value)">
        <option value="">-- Выберите страну --</option>
        <?php
        $pdo = connect();
        $res = $pdo->query("SELECT * FROM Countries");
        while($row = $res->fetch()) {
            echo "<option value='{$row['id']}'>{$row['country']}</option>";
        }
        ?>
    </select>

    <!-- Сюда AJAX будет подставлять таблицу -->
    <div id="cityTableContainer"></div>

    <script>
    function showCities(countryId) {
        const container = document.getElementById('cityTableContainer');
        
        if (countryId === "") {
            container.innerHTML = "";
            return;
        }

        // Создаем AJAX запрос (используем современный fetch)
        fetch('get_cities.php?countryid=' + countryId)
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
            })
            .catch(error => console.error('Ошибка:', error));
    }
    </script>

</body>
</html>
