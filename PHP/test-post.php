<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST данные получены:<br>";
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
} else {
    echo '<form method="post"><input name="test"><button>Отправить</button></form>';
}
?>
