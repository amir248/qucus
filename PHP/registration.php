<?php
include $_SERVER['DOCUMENT_ROOT']."/get/include.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        die("Пароли не совпадают");
    }

    // Хэшируем пароль
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Подключение к базе данных (mysqli)
    // $conn = mysqli_connect("localhost", "qucu", "pass", "excellent");

    // if (!$conn) {
    //     die("Ошибка подключения: " . mysqli_connect_error());
    // }
    // Дополнительные поля (если форма их не заполняет, оставляем пустыми)
    $Name = isset($_POST['Name']) ? trim($_POST['Name']) : '';
    $Lastname = isset($_POST['Lastname']) ? trim($_POST['Lastname']) : '';
    $age = isset($_POST['age']) ? trim($_POST['age']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $blod_type = isset($_POST['blod_type']) ? trim($_POST['blod_type']) : '';
    $profession = isset($_POST['profession']) ? trim($_POST['profession']) : '';
    $having_children = isset($_POST['having_children']) ? trim($_POST['having_children']) : '';
    $marital_status = isset($_POST['marital_status']) ? trim($_POST['marital_status']) : '';
    $hobby = isset($_POST['hobby']) ? trim($_POST['hobby']) : '';
    $education = isset($_POST['education']) ? trim($_POST['education']) : '';
    $visit_date = time(); // текущее время или 0

    // Экранирование
    $login_safe = mysqli_real_escape_string($link, $login);
    $email_safe = mysqli_real_escape_string($link, $email);
    $password_safe = mysqli_real_escape_string($link, $passwordHash);
    $Name_safe = mysqli_real_escape_string($link, $Name);
    $Lastname_safe = mysqli_real_escape_string($link, $Lastname);
    $age_safe = mysqli_real_escape_string($link, $age);
    $gender_safe = mysqli_real_escape_string($link, $gender);
    $blod_type_safe = mysqli_real_escape_string($link, $blod_type);
    $profession_safe = mysqli_real_escape_string($link, $profession);
    $having_children_safe = mysqli_real_escape_string($link, $having_children);
    $marital_status_safe = mysqli_real_escape_string($link, $marital_status);
    $hobby_safe = mysqli_real_escape_string($link, $hobby);
    $education_safe = mysqli_real_escape_string($link, $education);

    // Проверка уникальности email
    $email_safe = mysqli_real_escape_string($link, $email);
    $result = mysqli_query($link, "SELECT id FROM barbarians WHERE email='$email_safe'");

    

    if (mysqli_num_rows($result) > 0) {
        die("Пользователь с таким email уже существует");
    }

    // Сохранение пользователя
    $username_safe = mysqli_real_escape_string($link, $login);
    $password_safe = mysqli_real_escape_string($link, $passwordHash);

    // Добавление пользователя
    $query = "INSERT INTO barbarians
    (login, password, email, Name, Lastname, age, gender, blod_type, profession, having_children, marital_status, hobby, education, visit_date)
    VALUES
    ('$login_safe', '$password_safe', '$email_safe', '$Name_safe', '$Lastname_safe', '$age_safe', '$gender_safe', '$blod_type_safe', '$profession_safe', '$having_children_safe', '$marital_status_safe', '$hobby_safe', '$education_safe', '$visit_date')";

    
    if (mysqli_query($link, $query)) {
        echo "Регистрация успешна!";
    } else {
        echo "Ошибка: " . mysqli_error($link);
    }
if (mysqli_query($link, $query)) {
    echo $query;

}
    // Закрываем соединение
    mysqli_close($link);
}
?>
