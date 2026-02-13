<?php
session_start(); // Запуск сессии
if($_SESSION['user_id'] != 1){
            header("Location: authorization.php"); // Перенаправление на защищенную страницу
        exit;
}
    include $_SERVER['DOCUMENT_ROOT']."/get/include.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>add</title>
    <link rel="icon" href="img/js.svg" type="image/svg+xml">
</head>
<body>
    <h1>add</h1>
    <strong>add news post</strong>
    <form action="PHP/add.php" method="get">
        <fieldset>
            <label for="title">title</label>
            <input type="text" name="title" >
        </fieldset>
        <fieldset>
            <label for="description">description</label>
            <input type="text" name="description" >
        </fieldset>
        <fieldset>
            <label for="text">article</label>
            <textarea type="text" id="text" name="text" ><?= $text ?></textarea>
        </fieldset>
        <fieldset>
            <label for="JSON">JSON</label>
            <textarea type="text" id="JSON" name="JSON" ><?= $json ?></textarea>
        </fieldset>
        <fieldset>
            <label for="autor">autor</label>
            <input type="text" id="autor" name="autor" >
        </fieldset>
        <fieldset>
            <label for="js">js</label>
            <textarea type="text" id="js" name="js" ></textarea>
        </fieldset>
        <button type="submit">to Go</button>
    </form> 
</body>

</html>