<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.2018
 * Time: 11:38
 */
namespace Forecast;
use Forecast\Data\FifteenDayOfDaily;
use Forecast\Data\FiveDayOfDaily;
use Forecast\Data\OneDayOfDaily;
use Forecast\Data\TenDayOfDaily;

require "weather_config.php";


class Weather
{
    /**
     * @var int
     */
    private $city_code;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $metric;

    /**
     * @var string
     */
    private $url_one_day = 'http://dataservice.accuweather.com/forecasts/v1/daily/1day/';

    /**
     * @var string
     */
    private $url_five_day = 'http://dataservice.accuweather.com/forecasts/v1/daily/15day/';

    /**
     * @var string
     */
    private $url_ten_day = 'http://dataservice.accuweather.com/forecasts/v1/daily/10day/';

    /**
     * @var string
     */
    private $url_fifteen_day = 'http://dataservice.accuweather.com/forecasts/v1/daily/15day/';

    /**
     * @var string
     */
    private $key_param = '?apikey=';

    /**
     * @var string
     */
    private $lang_param = '&language=';

    /**
     * @var string
     */
    private $metric_param = '&metric=';
    
    /**
     * Weather constructor.
     */
    public function __construct()
    {
        $this->city_code = CITY_CODE;
        $this->key = WEATHER_KEY;
        $this->lang = LANG;
        $this->metric = METRIC;
    }


    /**
     * @return OneDayOfDaily
     */
    public function oneDay( ){
        $url = $this->createURL($this -> url_one_day);
        return new OneDayOfDaily( $this->execUrl($url) );
    }


    /**
     * @return FiveDayOfDaily
     */
    public function fiveDay(){
        $url = $this->createURL($this->url_five_day);
        return new FiveDayOfDaily( $this->execUrl($url) );
    }

    /**
     * @return TenDayOfDaily
     */
    public function tenDay(){
        $url = $this->createURL($this->url_ten_day);
        return new TenDayOfDaily( $this->execUrl($url) );
    }

    /**
     * @return FifteenDayOfDaily
     */
    public function fifteenDay(){
        $url = $this->createURL($this->url_fifteen_day);
        return new FifteenDayOfDaily( $this->execUrl($url) );
    }

    /**
     * @param $url
     * @return null|string
     */
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

    /**
     * @param $url
     * @return mixed
     */
    private function execUrl($url){
        return json_decode(file_get_contents($url), true);
    }
}