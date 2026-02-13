<?php
// Разрешаем междоменные запросы (CORS)
// header("Access-Control-Allow-Origin: https://fonolog.ru");
header("Content-Type: text/plain; charset=utf-8");

// Проверяем метод
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $headers = "From: tat1986@mail.ru\r\n";
    $headers .= "Reply-To: $to\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    // Фильтрация входящих данных
    $name     = htmlspecialchars(trim($_POST["name"] ?? ""));
    $phone    = htmlspecialchars(trim($_POST["phone"] ?? ""));
    $message  = htmlspecialchars(trim($_POST["message"] ?? ""));
    $preferred= htmlspecialchars(trim($_POST["preferred"] ?? ""));

    if (!$name || !$phone) {
        http_response_code(400);
        echo "Ошибка: заполните все обязательные поля.";
        exit;
    }

    // Куда отправляем письмо
    $to = "tat1986@mail.ru";
    $subject = "!!! Заявка с сайта (логопед онлайн) https://fonolog.ru/logoped-online";
    $body = "Имя: $name\nТелефон: $phone\nПредпочтительное время: $preferred\n\nСообщение:\n$message";
    $headers = "From: no-reply@fonolog.ru\r\nReply-To: $to\r\n";

    // Отправка
    if (mail($to, $subject, $body, $headers)) {
        echo "Спасибо! Ваша заявка отправлена.";
    } else {
        http_response_code(500);
        echo "Ошибка при отправке. Попробуйте позже.";
    }
} else {
    http_response_code(405);
    echo "Метод не разрешён.";
}
?>
