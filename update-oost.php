<?php
session_start(); // Запуск сессии
if($_SESSION['user_id'] != 1){
            header("Location: authorization.php"); // Перенаправление на защищенную страницу
        exit;
}
include $_SERVER['DOCUMENT_ROOT']."/get/include.php";
// echo $_SERVER['DOCUMENT_ROOT'];
   $sql = "SELECT * FROM article WHERE id=".htmlspecialchars($_GET["id"]);

$result = mysqli_query($link, $sql);
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Document</title>
    <style>
        *{
            margin:0;
            padding:0;
        }
        body{
            font-size:20px;
            margin-left:auto;
            margin-right:auto;
            width:100%;
            max-width:1300px;
        }
        main{
            display:grid;
            justify-content:center;
            align-items:center;
            width:100%;
        }
        article{
            display:grid;
            justify-content:center;
            align-items:center;
            
        }
        section{
            width:100%;
            display:grid;
            justify-content:space-between;
            align-items:center;
            grid-template-columns: repeat(3, 1fr);
            justify-items:center;
        }
        main > article > form{
            dispaly:grid;
            justify-content:center;
            align-items:center;
            width:calc(100% - 7px);
        }
        main > article > form > input,main > article > form > textarea{
            width:100%;
            max-width:1300px;
            font-size:20px;
        }
        main > article > form > textarea{
            min-height:300px;
            height:100%;
            border:0;
        }
        /* //body > main:nth-child(1) > article:nth-child(1) > form:nth-child(3) > input:nth-child(1) */
        article > form > button{
            width:100%;
            min-height:70px;
            background:coral;
            font-size:30px;
            color:white;
            text-shadow: black 3px 3px;
            transition:all 3s ease;
        }
        article > form > button:hover{
            background:#f77027;
        }
        form > span{
            color:yellow;
            background:black;
        }
    </style>
    <link rel="icon" href="img/js.svg" type="image/svg+xml">
</head>
<body>
    <main>
        <article>
    <h1>Updating</h1>

<?php

while ($row = mysqli_fetch_array($result)) {
    echo "<section>";
    // echo "<br>autor: ". $row['autor'];
    echo "<br> id: " . $row['id'] ." Post: " . "<a href=/blozhik/". $row['url'].">" . $row['title'] . "</a>". "<a href='/update.php' style='font-size:33px;'>main<br>update</a>"  ."<br>";
    echo "</section>";
    $id=$row['id'];
    $title=$row['title'];
    $description=$row["description"];
    $keywords=$row["keywords"];
    $json=$row["JSON"];
    $article=$row["text"];
    $autor=$row['autor'];
    $js=$row['js'];
    $url=$row['url'];
}
?>
<form action="/up-date.php" method="POST">
    <input type="text" name="id" value="<?= $id ?>">
    <span>title</span>
    <input type="text" name="title" value="<?= $title ?>">
    <span>description</span>
    <input type="text" name="description" value="<?= $description ?>">
    <span>JSON</span>
    <textarea type="text" name="JSON"><?= $json ?></textarea>
    <span>keywords</span>
    <input type="text" name="keywords" value="<?= $keywords ?>">
    <span>autor</span>
    <input type="text" name="autor" value="<?= $autor ?>">
    <span>js</span>
    <textarea type="text" name="js"><?= $js ?></textarea>
    <span>url</span>
    <input type="text" name="url" value="<?= $url ?>">
    
    <button type="submit">UPDATING</button>
</form>
<form action="/up-date-text.php" method="POST">
   <input type="text" name="id" value="<?= $id ?>">
    <span>Article</span>
    <textarea type="text" name="text"><?= $article ?></textarea>
   
    <button type="submit">UPDATING</button>
</form>
<!-- <button id="updating" type="submit">UPDATING</button> -->
        </article>
    </main>
</body>
</html>