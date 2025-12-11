<?php

namespace App\Data;

class WeatherData
{
    public string $city;
    public ?float $temperature;
    public ?string $weather_description;
    public string $timestamp;
    public string $source;

    public function __construct(
        string $city,
        ?float $temperature,
        ?string $weather_description,
        string $timestamp,
        string $source = 'external'
    ) {
        $this->city = $city;
        $this->temperature = $temperature;
        $this->weather_description = $weather_description;
        $this->timestamp = $timestamp;
        $this->source = $source;
    }
}
