<?php
include $_SERVER['DOCUMENT_ROOT']."/get/include.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    // Ищем пользователя по логину
    $login_safe = mysqli_real_escape_string($link, $login);
    $result = mysqli_query($link, "SELECT * FROM barbarians WHERE login='$login_safe' LIMIT 1");

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Проверяем пароль (новый способ через password_hash)
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            echo "Добро пожаловать, " . htmlspecialchars($user['login']);
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}
mysqli_close($link);
?>
