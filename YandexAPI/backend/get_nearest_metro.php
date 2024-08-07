<?php

require 'get_dotenv_vars.php';
require 'ApiCall.php';


$env_path = '.env';
get_dotenv_vars($env_path);


$position = $_GET['address'];

$status = 200;
$data = "";


// Формируем запрос к геокодеру
$url = 'https://geocode-maps.yandex.ru/1.x/';
$params = [
    'format' => 'json',
    'apikey' => $_ENV['API_KEY'],
    'geocode' => $position,
    'lang' => 'ru_RU',
    'results' => '1',
];
$headers = [
    'Referer: http://localhost'
];


// Делаем запрос
$api = new ApiCall();
$response = $api->call($url, $params, $headers);

if ($response['ok']) {
    // Полученные координаты текущего местоположения используем
    // Для нахождения ближайшего метро по этим координатам.
    // Используем get_all_coordinates, get_all_addresses для парсинга ответов
    $position = $api->get_all_coordinates($response['content'])[0];
    $new_params = $params;
    $new_params['geocode'] = $position['latitude'] . ',' . $position['longitude'];
    $new_params['kind'] = 'metro';
    $new = $api->call($url, $new_params, $headers);
    if ($new['ok']) {
        $address = $api->get_all_addresses($new['content']);
        if ($address) {
            $data = $address[0];
        } else {
            $data = "";
        }
    } else {
        $status = 500;
        $data = $new['content'];
    }
} else {
    $status = 400;
    $data = $response['content'];
}

// Формируем ответ клиенту
header('Content-Type: application/json');
http_response_code($status);
echo json_encode([
    'data' => $data
]);
