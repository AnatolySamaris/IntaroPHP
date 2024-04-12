<?php

try {
    $pdo = new \PDO("pgsql:host=postgres;dbname=postgres", 'postgres', 'password');
    echo "Подключение к базе данных установлено! <br>";

    return;
} catch (PDOException $exception) {
    echo "Ошибка при подключении к базе данных<br><b>{$exception->getMessage()}</b><br>";
}