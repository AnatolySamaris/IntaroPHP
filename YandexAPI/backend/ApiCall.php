<?php

/**
 * Класс для удобной работы с API яндекс геокодера.
 * Позволяет сделать правильный запрос методом call, 
 * а также извлечь необходимые данные служебными методами.
 */
class ApiCall
{
    function __construct()
    {
    }

    function call(string $url, array $params, array $headers) : array
    {
        // Строим параметризованный запрос
        $ch = curl_init($url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return array(
                "ok" => false,
                "content" => curl_error($ch)
            );
        } else {
            return array(
                "ok" => true,
                "content" => $response
            );
        }
    }

    // Парсим ответ, доставая координаты всех полученных точек
    function get_all_coordinates(string $response) : array
    {
        $json = json_decode($response, true);
        $found_objects = $json['response']['GeoObjectCollection']['featureMember'];
        
        $coordinates = array();
        foreach ($found_objects as $obj) {
            $obj_coord = explode(' ', $obj['GeoObject']['Point']['pos']);
            $coordinates[] = array(
                'longitude' => $obj_coord[1],
                'latitude' => $obj_coord[0]
            );
        }

        return $coordinates;
    }

    // Парсим ответ, получая адреса подходящие под указанные в запросе координаты
    function get_all_addresses(string $response) : array
    {
        try {
            $json = json_decode($response, true);
            $found_objects = $json['response']['GeoObjectCollection']['featureMember'];

            $addresses = array();
            foreach  ($found_objects as $obj) {
                $addresses[] = $obj['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
            }

            return $addresses;
        } catch (\Throwable $th) {
            return array();
        }
    }
}