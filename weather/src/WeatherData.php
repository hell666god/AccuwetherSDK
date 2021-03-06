<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.2018
 * Time: 19:19
 */
namespace Weather;

class WeatherData
{
    private $weather_data;

    /**
     * WeatherData constructor.
     * @param $weather_data
     */
    public function __construct(array $weather_data){
        $this->weather_data = $weather_data;
    }

    public function getDayTemp(){
        return $this->weather_data["DailyForecasts"][0]["Temperature"]["Maximum"]["Value"];
    }

    public function getNightTemp(){
        return $this->weather_data["DailyForecasts"][0]["Temperature"]["Minimum"]["Value"];
    }

    public function getDayIcon(){
        return $this->weather_data["DailyForecasts"][0]["Day"]["Icon"];
    }

    public function getNightIcon(){
        return $this->weather_data["DailyForecasts"][0]["Night"]["Icon"];
    }

}