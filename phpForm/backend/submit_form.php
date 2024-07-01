<?php

require('data_manipulation.php');
require('send_email.php');
require('get_dotenv_vars.php');


$env_path = '.env';
get_dotenv_vars($env_path);


$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

$status = 200;
$message = "";
$data = "";

try {
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comment = $_POST['comment'];
    
    $data = array(
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "comment" => $comment
    );

    $is_available_array = isAvailableToCreate($pdo, $data);

    if ($is_available_array[0]) {
        
        $created_id = createApplication($pdo, $data);

        $from_email = "tolik09102003@gmail.com";
        $to_email = "anatolysamaris@gmail.com";
        $title = "Заявка №". $created_id;
        $auth_data = array(
            'host' => $_ENV['EMAIL_HOST'],
            'smtp_secure' => $_ENV['EMAIL_SMTP_SECURE'],
            'port' => $_ENV['EMAIL_PORT'],
            'username' => $_ENV['EMAIL_USER'],
            'password' => $_ENV['EMAIL_PASSWORD'],
        );

        $send = send_email($title, $from_email, $to_email, $data, $auth_data);

        if ($send[0]) {
            $status = 201;
            $data = $is_available_array[1];
        } else {
            $message = $send[1];
            $status = 502;
        }
    } else {
        $status = 409;
        $data = $is_available_array[1];
    }
} catch (\Throwable $e) {
    $status = 500;
    $message = $e->getMessage();
}


header('Content-Type: application/json');
http_response_code($status);
echo json_encode(['message' => $message, 'data' => $data]);
