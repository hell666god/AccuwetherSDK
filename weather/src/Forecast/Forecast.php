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

require "../weather_config.php";


class Forecast
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
     * Forecast constructor.
     * Set parameters of config.php
     */
    public function __construct(){
        $this->city_code = CITY_CODE;
        $this->key = WEATHER_KEY;
        $this->lang = LANG;
        $this->metric = METRIC;
    }

    /**
     * @param int $city_code
     */
    public function setCityCode(int $city_code): void
    {
        $this->city_code = $city_code;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * @param string $metric
     */
    public function setMetric(string $metric): void
    {
        $this->metric = $metric;
    }


    /**
     * @return OneDayOfDaily
     */
    public function oneDay( ): OneDayOfDaily{
        $url = $this->createURL($this -> url_one_day);
        return new OneDayOfDaily( $this->execUrl($url) );
    }


    /**
     * @return FiveDayOfDaily
     */
    public function fiveDay(): FiveDayOfDaily{
        $url = $this->createURL($this->url_five_day);
        return new FiveDayOfDaily( $this->execUrl($url) );
    }

    /**
     * @return TenDayOfDaily
     */
    public function tenDay(): TenDayOfDaily{
        $url = $this->createURL($this->url_ten_day);
        return new TenDayOfDaily( $this->execUrl($url) );
    }

    /**
     * @return FifteenDayOfDaily
     */
    public function fifteenDay(): FifteenDayOfDaily{
        $url = $this->createURL($this->url_fifteen_day);
        return new FifteenDayOfDaily( $this->execUrl($url) );
    }

    /**
     * @param $url
     * @return string
     */
    private function createURL($url): string{
        if (!$this -> key){
            throw new \RuntimeException("Key must be not void!");
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
    private function execUrl($url): array{
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $this->isValid(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);
        return $result;
    }

    /**
     * @param $http_code
     */
    private function isValid($http_code): void{
        if ($http_code === 400){
            throw new \RuntimeException('Request had bad syntax or the parameters supplied were invalid');
        }
        if ($http_code === 401){
            throw new \RuntimeException('Unauthorized. API authorization failed');
        }
        if ($http_code === 403){
            throw new \RuntimeException('Unauthorized. You do not have permission to access this endpoint');
        }
        if ($http_code === 404){
            throw new \RuntimeException('Server has not found a route matching the given URI');
        }
        if ($http_code === 500){
            throw new \RuntimeException('Server encountered an unexpected condition which prevented it from fulfilling the request');
        }
    }
}