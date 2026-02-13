<?php
// session_start(); // Запуск сессии
// if($_SESSION['user_id'] != 1){
//             header("Location: authorization.php"); // Перенаправление на защищенную страницу
//         exit;
// }
// include $_SERVER['DOCUMENT_ROOT']."/get/include.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);
$link=mysqli_connect("localhost","qucu","Gfhjkm123", "excellent");
    if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    else {
        print("Соединение установлено успешно");
    }
mysqli_set_charset($link, "utf8");
header('Content-Type: text/html; charset=utf-8');



// $title = "не определено";
// $autor = "не определен";
// $description = $_POST['description'];
if(isset($_GET["title"])){
    $title = $_GET["title"];
}
if(isset($_GET["description"])){
    $description = $_GET["description"];
}
if(isset($_POST["text"])){
    $text = $_POST["text"];
}
if(isset($_POST["JSON"])){
    $json = $_POST["JSON"];
}
if(isset($_POST["autor"])){
    $autor = $_POST["autor"];
}
if(isset($_POST["js"])){
    $js = $_POST["js"];
}
if(isset($_POST["id"])){
    $id = $_POST["id"];
}else{
    echo " ELSE";
}
// echo "Имя: $title <br> autor: $autor";

$title = mysqli_real_escape_string($link, $_GET["title"]);
echo "<br>";
$description = mysqli_real_escape_string($link, $_GET["description"]);
echo "<br>";
$text = mysqli_real_escape_string($link, $_GET["text"]);
echo "<br>";
$json = mysqli_real_escape_string($link, $_GET["JSON"]);
echo "<br>";
$autor = mysqli_real_escape_string($link, $_GET["autor"]);
echo "<br>";
$js = mysqli_real_escape_string($link, $_GET["js"]);
// $sql = "UPDATE article SET title = '$title', description='$description', json='$json', autor='$autor', js='$js' WHERE id='$id'";
// // echo '<br> '. $id . " " . $title;
// if (mysqli_query($link, $sql)) {
//     // header("Refresh: 3; URL=/update.php"); 
// } else {
//     echo "<br>Error updating record: " . mysqli_error($link);
// }
// mysqli_close($link);
// sleep(3);
// header("Location: /update.php"); 
//,description,text,json,autor,js
//,$description,$text,$json,$autor,$js
// $title = mysqli_real_escape_string($link, $_POST["title"]);
$sql = "INSERT INTO article (title, description,text,json,autor,js) VALUES ('$title', '$description','$text','$json','$autor','$js')";
if (mysqli_query($link, $sql)) {
    echo "Данные успешно добавлены";
    header("Refresh: 3; URL=/update.php"); 
} else{
    echo "Ошибка: "  . mysqli_error($link);
}
mysqli_close($link);
?>