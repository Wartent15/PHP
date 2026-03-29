<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Работа с цветом RGB</title>
    <style>
        .color-box {
            padding: 20px;
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
            border: 1px solid #000;
        }
        input { width: 50px; margin-right: 10px; }
    </style>
</head>
<body>

    <form method="POST">
        R: <input type="number" name="r" min="0" max="255" required value="<?= $_POST['r'] ?? 0 ?>">
        G: <input type="number" name="g" min="0" max="255" required value="<?= $_POST['g'] ?? 0 ?>">
        B: <input type="number" name="b" min="0" max="255" required value="<?= $_POST['b'] ?? 0 ?>">
        <button type="submit" name="accept">Accept</button>
    </form>

    <?php
    if (isset($_POST['accept'])) {
        // Получаем значения из полей
        $r = intval($_POST['r']);
        $g = intval($_POST['g']);
        $b = intval($_POST['b']);

        // Формируем основной цвет
        $bgColor = "rgb($r, $g, $b)";

        // Вычисляем дополнительный (инверсный) цвет для текста
        $ir = 255 - $r;
        $ig = 255 - $g;
        $ib = 255 - $b;
        $textColor = "rgb($ir, $ig, $ib)";

        // Выводим результат
        echo "<br><span class='color-box' style='background-color: $bgColor; color: $textColor;'>";
        echo "Этот текст залит дополнительным цветом на выбранном фоне";
        echo "</span>";
    }
    ?>

</body>
</html>