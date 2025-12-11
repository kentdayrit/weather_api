<?php

namespace Tests\Unit;

use App\Data\WeatherData;
use App\Services\WeatherService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/**
 * Class WeatherServiceTest
 *
 * Unit tests for the WeatherService class.
 *
 * @package Tests\Unit
 */
class WeatherServiceTest extends TestCase
{
    /**
     * Test that getCityWeather() returns the expected WeatherData object.
     *
     * Uses a Guzzle MockHandler to simulate an external API response.
     * Asserts that:
     *  - The returned object is an instance of WeatherData
     *  - The object has correct property values
     *
     * @return void
     */
    public function test_getCityWeather_returns_expected_array()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'name' => 'Manila',
                'main' => ['temp' => 30],
                'weather' => [['description' => 'clear sky']]
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new WeatherService($client);

        $result = $service->getCityWeather('Manila');

        $this->assertInstanceOf(WeatherData::class, $result);
        $this->assertEquals('Manila', $result->city);
        $this->assertEquals(30, $result->temperature);
        $this->assertEquals('clear sky', $result->weather_description);
        $this->assertNotEmpty($result->timestamp);
        $this->assertEquals('external', $result->source);
    }

    /**
     * Test that getCityWeather() throws an exception when API key is missing.
     *
     * Sets the OpenWeather API key to null via config and expects an HttpException
     * to be thrown when the service attempts to fetch data.
     *
     * @return void
     */
    public function test_missing_api_key_throws_exception()
    {
        $this->app['config']->set('services.openweather.key', null);

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
            'timeout'  => 5,
        ]);

        $service = new \App\Services\WeatherService($client);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $service->getCityWeather('Manila');
    }
}
