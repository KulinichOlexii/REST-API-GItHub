<?php


namespace App\Service\ValueObject;

class WeatherResponse
{
    /**
     * @var string|null
     */
    private $weather;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $icon;

    /**
     * @var float|null
     */
    private $temp;

    /**
     * @var string|null
     */
    private $tempType;

    /**
     * GitHubUserResponse constructor.
     * @param string $weather
     * @param string $description
     * @param string $icon
     * @param float $temp
     * @param string $tempType
     */
    public function __construct($weather, $description, $icon, $temp, $tempType = 'Celsius')
    {
        $this->weather = $weather;
        $this->description = $description;
        $this->icon = $icon;
        $this->temp = $temp;
        $this->tempType = $tempType;
    }

    /**
     * @return null|string
     */
    public function getWeather(): ?string
    {
        return $this->weather;
    }

    /**
     * @param null|string $weather
     */
    public function setWeather(?string $weather): void
    {
        $this->weather = $weather;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param null|string $icon
     */
    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return float|null
     */
    public function getTemp(): ?float
    {
        return $this->temp;
    }

    /**
     * @param float|null $temp
     */
    public function setTemp(?float $temp): void
    {
        $this->temp = $temp;
    }

    /**
     * @return null|string
     */
    public function getTempType(): ?string
    {
        return $this->tempType;
    }

    /**
     * @param null|string $tempType
     */
    public function setTempType(?string $tempType): void
    {
        $this->tempType = $tempType;
    }

    /**
     * @param string $json
     * @return static
     */
    public static function createFromJson(string $json)
    {
        $data = json_decode($json, true);

        $weather = null;
        if (isset($data['weather']) && isset($data['weather'][0])) {
            $weather = (string) $data['weather'][0]['main'];
        }

        $description = null;
        if (isset($data['weather']) && isset($data['weather'][0])) {
            $description = (string) $data['weather'][0]['description'];
        }

        $icon = null;
        if (isset($data['weather']) && isset($data['weather'][0])) {
            $icon = (string) $data['weather'][0]['icon'];
        }

        $temp = null;
        if (isset($data['main'])) {
            $temp = (float) $data['main']['temp'] - 273.15;
        }

        $obj = new static($weather, $description, $icon, $temp);

        return $obj;
    }
}