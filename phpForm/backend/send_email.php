<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

/**
 * Функция отправки письма на почту менеджера с данными из формы при помощи PHPMailer.
 * Если отправлено успешно - возвращает массив [true, 'success'], иначе
 * массив [false, $Описание_ошибки]
 */
function send_email(string $application_title, string $from, string $to, array $data, array $auth_data) {    
    $body = "
    <h2>{$application_title}</h2>
    <b>Имя:</b> {$data['name']}<br>
    <b>Почта:</b> {$data['email']}<br>
    <b>Телефон:</b> {$data['phone']}<br><br>
    <b>Сообщение:</b><br>{$data['comment']}
    ";

    $mail = new PHPMailer(true);
    
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    
    $mail->Host       = $auth_data['host'];
    $mail->Username   = $auth_data['username'];
    $mail->Password   = $auth_data['password'];
    $mail->SMTPSecure = $auth_data['smtp_secure'];
    $mail->Port       = $auth_data['port'];
    
    $mail->setFrom($from, 'PHP Form');
    $mail->addAddress($to);  
    
    $mail->isHTML(true);
    $mail->Subject = "PHP Form | Новая заявка";
    $mail->Body = $body;    

    if ($mail->send()) {
        return [true, 'success'];
    } else {
        return [false, $mail->ErrorInfo];
    }
}