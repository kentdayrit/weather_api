<?php

namespace App\Services;

use App\Data\WeatherData;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherService {

    public function __construct(
        protected readonly Client $client
    )
    {}

    /**
     * Fetch weather data for a city.
     *
     * @param string $city
     * @return WeatherData
     * @throws HttpException
     */
    public function getCityWeather(string $city): WeatherData
    {
        $apiKey = config('services.openweather.key');

        if (!$apiKey) {
            throw new HttpException(500, "Missing OpenWeather API key");
        }

        try {
            $response = $this->client->request('GET', 'weather', [
                'query' => [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric'
                ]
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new HttpException(
                $e->getCode() ?: 502,
                "Failed to fetch weather for {$city}: " . $e->getMessage()
            );
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return new WeatherData(
            city: $data['name'] ?? $city,
            temperature: $data['main']['temp'] ?? null,
            weather_description: $data['weather'][0]['description'] ?? null,
            timestamp: Carbon::now()->toDateTimeString(),
            source: 'external'
        );
    }
}