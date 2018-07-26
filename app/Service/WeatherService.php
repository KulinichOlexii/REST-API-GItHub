<?php

namespace App\Service;


use App\Service\ValueObject\WeatherResponse;
use GuzzleHttp\Client;

class WeatherService
{
    /**
     * @var string $apiUrl
     */
    private $apiUrl = 'http://api.openweathermap.org/data/2.5/weather?';

    /**
     * @var string $apiKey
     */
    private $apiKey = 'b9e34eefab1d09fab29e8886e53dcb34';

    /**
     * @var string $apiEndpoint
     */
    private $apiEndpoint = '';

    /**
     * @param $city
     * @return WeatherResponse
     */
    public function getWeatherByCity($city)
    {
        $this->setApiEndpoint('q=' . $city . '&APPID=' . $this->apiKey);

        $result = $this->callApiGet();

        $result = WeatherResponse::createFromJson($result);

        return $result;
    }

    /**
     * @param $params
     * @return string
     */
    protected function callApiGet()
    {
        $client = new Client();
        $response = $client->get(
            $this->apiEndpoint
        );
        $result = $response->getBody()->getContents();

        return $result;
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->apiEndpoint;
    }

    /**
     * @param string $apiEndpoint
     */
    public function setApiEndpoint(string $apiEndpoint): void
    {
        $this->apiEndpoint = $this->apiUrl . $apiEndpoint;
    }
}