<?php
/***
// Подключение к базе данных
$host = 'postgres';
$dbname = 'postgres';
$username = 'postgres';
$password = 'password';

$db = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);

// Получение данных из формы
$surname = $_POST['surname'];
$name = $_POST['name'];
$patronymic = $_POST['patronymic'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$comment = $_POST['comment'];
*/

$value = getcwd();
header('Content-Type: application/json');
echo json_encode(['value' => $value]);

/***
// Проверка наличия заявки с таким email в течение последнего часа
$existingAppQuery = $db->prepare("SELECT created_at FROM applications WHERE email = :email ORDER BY created_at DESC LIMIT 1");
$existingAppQuery->execute(['email' => $email]);
$lastApp = $existingAppQuery->fetch();

if ($lastApp && strtotime($lastApp['created_at']) > strtotime('-1 hour')) {
    $nextAllowedTime = date('H:i:s', strtotime($lastApp['created_at'] . ' +1 hour'));
    echo "Нельзя создавать повторную заявку раньше, чем через час. Повторно можно будет через $nextAllowedTime.";
} else {
    // Сохранение заявки в базе данных
    $insertQuery = $db->prepare("INSERT INTO applications (name, email, phone, comment, created_at) VALUES (:name, :email, :phone, :comment, NOW())");
    $insertQuery->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'comment' => $comment]);

    // Отправка письма на email менеджера
    $to = 'mynameisantontoo@gmail.com';
    $subject = 'Заявка №';
    $message = "Имя: $name\nEmail: $email\nТелефон: $phone\nКомментарий: $comment";
    $headers = 'From: my_service@docker.com';

    mail($to, $subject, $message, $headers);

    echo "Заявка успешно оформлена!";
}

*/