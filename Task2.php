<?php
function draw_calendar($month) {
    if (!is_int($month) || $month < 1 || $month > 12) {
        echo "<p style='color: red;'>Ошибка: Некорректный номер месяца (должен быть от 1 до 12).</p>";
        return;
    }

    $year = date("Y");
    $first_day_timestamp = mktime(0, 0, 0, $month, 1, $year);
    
    $month_name = date("F", $first_day_timestamp);
    $days_in_month = date("t", $first_day_timestamp);
    $first_day_of_week = date("N", $first_day_timestamp);

    echo "<table border='1' cellpadding='5' style='border-collapse: collapse; text-align: center;'>";
    echo "<caption><h3>$month_name $year</h3></caption>";
    echo "<tr style='background: #eee;'>
            <th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th style='color:red;'>Сб</th><th style='color:red;'>Вс</th>
          </tr>";

    echo "<tr>";

    for ($i = 1; $i < $first_day_of_week; $i++) {
        echo "<td></td>";
    }

    $current_day = 1;
    $day_of_week_counter = $first_day_of_week;

    while ($current_day <= $days_in_month) {
        $style = ($day_of_week_counter >= 6) ? "style='color: red;'" : "";
        
        echo "<td $style>$current_day</td>";

        if ($day_of_week_counter == 7 && $current_day < $days_in_month) {
            echo "</tr><tr>";
            $day_of_week_counter = 1;
        } else {
            $day_of_week_counter++;
        }
        $current_day++;
    }

    while ($day_of_week_counter <= 7 && $day_of_week_counter != 1) {
        echo "<td></td>";
        $day_of_week_counter++;
    }

    echo "</tr></table>";
}
draw_calendar(3);
?>
