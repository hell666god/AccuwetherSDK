<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.2018
 * Time: 11:38
 */
namespace Weather;

require "weather_config.php";

class Weather
{
    private $city_code;
    private $key;
    private $lang;
    private $metric;

    private $url_1day = 'http://dataservice.accuweather.com/forecasts/v1/daily/1day/';

    private $key_param = '?apikey=';
    private $lang_param = '&language=';
    private $metric_param = '&metric=';

    /**
     * weather constructor.
     * @param $city_code
     * @param $key
     * @param $lang
     * @param $metric
     */
    public function __construct()
    {
        $this->city_code = CITY_CODE;
        $this->key = WEATHER_KEY;
        $this->lang = LANG;
        $this->metric = METRIC;
    }


    public function day_1( ){
        $url = $this->createURL($this -> url_1day);
        $result = file_get_contents($url);
        $result = json_decode($result, true);

        return new WeatherData($result);
    }

    private function createURL($url){
        if (!$this -> key){
            return null;
        }else{
            $url .= $this->city_code . $this->key_param . $this -> key;
        }

        if($this -> lang){
            $url .= $this->lang_param . $this -> lang;
        }

        if($this -> metric){
            $url .= $this->metric_param . $this -> metric;
        }

        return $url;
    }
}