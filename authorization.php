    <?php
    session_start(); // Запуск сессии

    include $_SERVER['DOCUMENT_ROOT']."/get/include.php";

    $sql = "SELECT * FROM barbarians";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_array($result)) {
        // echo "<section>";
        // echo "login: " . $row['login'] ."<br>" . $row['password'] .   "<br>";
        // echo "</section>";
        // Обработка формы авторизации
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $login = $_POST['login'];
            $password  = $_POST['password'];

            // Проверка пароля (в реальном приложении нужно хешировать пароли!)
            if ($login == $row['login'] && $password == $row['password']) {
                $_SESSION['user_id'] = 1; // Сохраняем ID пользователя в сессию
                header("Location: update.php"); // Перенаправление на защищенную страницу
                exit;
                $aforementioned=false;
            } else {
                $aforementioned=true;
                
            }
        }
    }//while

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>authorization</title>
    <meta name="robots" content="noindex">
    <style>
        *{
        margin:0;
        paddeing:0;
        
        }
        body{
            width:100%;
            min-height:100vh;
        }
        body > form{
            display:grid;
            justify-content:center;
            align-items:center;
            justify-item:center;
        }
    </style>
    <link rel="icon" href="img/js.svg" type="image/svg+xml">
</head>
<body>
<i id='infon' style="color:red;text-shadow:1px 1px black;"></i>

<!-- Форма авторизации -->
<form method="post" action="/authorization.php">
    <label for="login">Логин:</label>
    <input type="text" id="login" name="login">

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password">

    <button type="submit">Войти</button>
</form>
</body>
<script>
    if(<?= $aforementioned==true ?>){
        // console.log('true');
        document.querySelector("#infon").innerHTML='Неправильный логин или пароль!';
    }
</script>
</html>