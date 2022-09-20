<?php

namespace classes;

class Weather
{
    public static function getActualCity()
    {
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'));

        if ($query && $query['status'] == 'success') {
            return $query['city'];
        }
    }

    public static function getWeather()
    {
        $city = Weather::getActualCity();
        $api_key = 'e228fcd450eb81971ea0491a6a3f0a76';
        $url = 'https://api.openweathermap.org/data/2.5/weather';
        $option = [
            'q' => $city,
            'APPID' => $api_key,
            'units' => 'metric',
            'lang' => 'en'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($option));
        $response = curl_exec($ch);
        $data = json_decode($response, true);

        foreach ($data as $value) {

            if ($value == $city) {
                $temp = round($data['main']['temp']);
                $humidity = $data['main']['humidity'];
                echo "$value, temperature: $temp, humidity: $humidity";
            }
        }

        curl_close($ch);
    }
}