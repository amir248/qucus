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
    <title>Document</title>
    <link rel="icon" href="img/js.svg" type="image/svg+xml">
</head>
<body>
    <h1>... text updating</h1>

</body>

</html>


<?php



// $description = $_POST['description'];

if(isset($_POST["text"])){
    $text = $_POST["text"];
}
if(isset($_POST["id"])){
    $id = $_POST["id"];
}else{
    echo " ELSE";
}

// $sql = "UPDATE article SET title = '$title', description='$description',  json='$json', autor='$autor' WHERE id='$id'";
echo $text . " ". $id;
$sql = "UPDATE article SET text='$text' WHERE id='$id'";
// echo '<br> '. $id . " " . $title;
if (mysqli_query($link, $sql)) {
    header("Refresh: 3; URL=/update.php"); 
} else {
    echo "<br>Error updating record: " . mysqli_error($link);
}
mysqli_close($link);
// sleep(3);
// header("Location: /update.php"); 
?>