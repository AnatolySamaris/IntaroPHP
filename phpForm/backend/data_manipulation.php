<?php
date_default_timezone_set('Europe/Moscow');

/**
 * Проверка по email, можно ли создать ещё запись.
 * Если нет - возвращает [false, $Сколько_минут_ждать].
 * Если да - возвращает [true, $текущее_время_плюс_полтора_часа].
 */
function isAvailableToCreate($pdo, $data)  : array
{
    $select_query = "
    SELECT * 
    FROM application
    WHERE email=:email
    ORDER BY created_at DESC
    LIMIT 1
    ";
    $stmt = $pdo->prepare($select_query);
    
    $stmt->bindParam(':email', $data['email']);

    $stmt->execute();
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($applications) > 0) {

        $application_created_at = $applications[0]['created_at'];
        $created_at_time = new DateTime($application_created_at);
        $current_time = new DateTime('now', new DateTimeZone('Europe/Moscow'));
        $interval = $current_time->diff($created_at_time);
        $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
        if ($interval->days == 0 && $interval->h == 0 && $minutes < 60) {
            return [false, 60 - $minutes];
        } else {
            // Сразу получаем время + полтора часа через которые свяжутся
            $interval = new DateInterval('PT1H30M');
            $current_time->add($interval);
            return [true, $current_time->format('H:i:s d.m.Y')];
        }
    } else {
        return [true, new DateTime('now', new DateTimeZone('Europe/Moscow'))];
    }
}

/**
 * Создаем заявку и записываем в бд. Возвращаем id новой заявки.
 */
function createApplication($pdo, $data) : string
{
    $insert_query = "
    INSERT into application(username, email, phone, user_comment)
    VALUES (:username, :email, :phone, :user_comment)
    ";

    $stmt = $pdo->prepare($insert_query);

    $stmt->bindParam(':username', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':user_comment', $data['comment']);

    $stmt->execute();

    return $pdo->lastInsertId();
}