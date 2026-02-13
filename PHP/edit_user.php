<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/get/include.php";

// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    die("Доступ запрещён. Войдите в систему.");
}

$user_id = $_SESSION['user_id'];

// Если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name = trim($_POST['Name']);
    $Lastname = trim($_POST['Lastname']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $hobby = trim($_POST['hobby']);

    // Экранируем
    $Name_safe = mysqli_real_escape_string($link, $Name);
    $Lastname_safe = mysqli_real_escape_string($link, $Lastname);
    $age_safe = mysqli_real_escape_string($link, $age);
    $gender_safe = mysqli_real_escape_string($link, $gender);
    $hobby_safe = mysqli_real_escape_string($link, $hobby);

    $query = "UPDATE barbarians 
              SET Name='$Name_safe', Lastname='$Lastname_safe', age='$age_safe', gender='$gender_safe', hobby='$hobby_safe' 
              WHERE id=$user_id";

    if (mysqli_query($link, $query)) {
        echo "Данные обновлены!";
    } else {
        echo "Ошибка: " . mysqli_error($link);
    }
}

// Загружаем текущие данные пользователя
$result = mysqli_query($link, "SELECT * FROM barbarians WHERE id=$user_id LIMIT 1");
$user = mysqli_fetch_assoc($result);

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование профиля</title>
</head>
<body>
    <h1>Редактировать профиль</h1>
    <form method="POST">
        <input type="text" name="Name" placeholder="Имя" value="<?= htmlspecialchars($user['Name']) ?>"><br>
        <input type="text" name="Lastname" placeholder="Фамилия" value="<?= htmlspecialchars($user['Lastname']) ?>"><br>
        <input type="text" name="age" placeholder="Возраст" value="<?= htmlspecialchars($user['age']) ?>"><br>
        <input type="text" name="gender" placeholder="Пол" value="<?= htmlspecialchars($user['gender']) ?>"><br>
        <input type="text" name="hobby" placeholder="Хобби" value="<?= htmlspecialchars($user['hobby']) ?>"><br>
        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
