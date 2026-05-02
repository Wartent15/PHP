<?php
if (isset($_GET['check_login'])) {
    $login = trim($_GET['check_login']);
    
    $existing_users = ['admin', 'ivan', 'user777', 'petr'];

    // Проверяем уникальность
    if (in_array(strtolower($login), array_map('strtolower', $existing_users))) {
        echo "занят";
    } else {
        echo "свободен";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация с AJAX проверкой</title>
    <style>
        .form-group { margin-bottom: 15px; }
        #status { font-size: 0.9em; font-weight: bold; margin-left: 10px; }
        .error { color: red; }
        .success { color: green; }
        input.invalid { border: 2px solid red; }
    </style>
</head>
<body>

    <h2>Регистрация нового пользователя</h2>

    <form id="registrationForm" action="save.php" method="POST">
        <div class="form-group">
            <label for="login">Придумайте логин:</label><br>
            <!-- Событие onblur срабатывает, когда пользователь уходит из поля -->
            <input type="text" id="login" name="login" required onblur="checkLoginUnique(this.value)">
            <span id="status"></span>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" id="submitBtn">Зарегистрироваться</button>
    </form>

    <script>
    function checkLoginUnique(login) {
        const statusSpan = document.getElementById('status');
        const loginInput = document.getElementById('login');
        const submitBtn = document.getElementById('submitBtn');

        // Если поле пустое, ничего не делаем
        if (login.length === 0) {
            statusSpan.innerHTML = "";
            return;
        }

        statusSpan.innerHTML = "Проверка...";
        statusSpan.className = "";

        const xhr = new XMLHttpRequest();

        xhr.open('GET', '?check_login=' + encodeURIComponent(login), true);

        // 3. Обрабатываем ответ от сервера
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText.trim();

                if (response === "занят") {
                    statusSpan.innerHTML = "❌ Этот логин уже занят!";
                    statusSpan.className = "error";
                    loginInput.classList.add('invalid');
                    submitBtn.disabled = true; // Блокируем отправку формы
                } else {
                    statusSpan.innerHTML = "✅ Логин свободен";
                    statusSpan.className = "success";
                    loginInput.classList.remove('invalid');
                    submitBtn.disabled = false; // Разрешаем отправку
                }
            }
        };

        xhr.send();
    }
    </script>

</body>
</html>
