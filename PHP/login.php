<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/get/include.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    // Экранируем
    $login_safe = mysqli_real_escape_string($link, $login);

    // Проверяем, есть ли пользователь
    $result = mysqli_query($link, "SELECT * FROM barbarians WHERE login='$login_safe' LIMIT 1");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Сверяем пароль
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            echo "✅ Авторизация успешна!";
        } else {
            echo "❌ Неверный пароль";
        }
    } else {
        echo "❌ Пользователь не найден";
    }

    mysqli_close($link);
    exit;
}
?>
<!-- 
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <style>
        input, button { display:block; margin: 5px 0; }
        #message { margin-top: 10px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Вход</h1>
    <form id="loginForm">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>

    <div id="message"></div>

    <script>
        const form = document.getElementById('loginForm');
        const message = document.getElementById('message');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                message.innerHTML = data;
                if (data.includes("✅")) {
                    message.className = 'success';
                    setTimeout(() => {
                        window.location.href = "edit_user.php"; // например, в личный кабинет
                    }, 1500);
                } else {
                    message.className = 'error';
                }
            })
            .catch(err => {
                message.innerHTML = "Ошибка: " + err;
                message.className = 'error';
            });
        });
    </script>
</body>
</html> -->
