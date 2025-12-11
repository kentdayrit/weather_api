<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Class WeatherApiTest
 *
 * Feature tests for the Weather API endpoints.
 *
 * @package Tests\Feature
 */
class WeatherApiTest extends TestCase
{
    /**
     * Class WeatherApiTest
     *
     * Feature tests for the Weather API endpoints.
     *
     * @package Tests\Feature
     */
    public function test_weather_external_endpoint(): void
    {
        $response = $this->getJson('/api/weather/Manila');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data' => [
                        'city',
                        'temperature',
                        'weather_description',
                        'timestamp',
                        'source'
                    ]
                ])
                ->assertJsonPath('data.source', 'external');
    }

    /**
     * Test the cached weather endpoint.
     *
     * Sends a GET request to `/api/weather/{city}/cached` twice to ensure:
     *  - The first request caches the data
     *  - The second request returns data from cache
     *  - Response status is 200
     *  - JSON structure contains 'status', 'message', and 'data' fields
     *  - 'data' contains 'city', 'temperature', 'weather_description', 'timestamp', and 'source'
     *  - 'source' is 'cache' for cached response
     *
     * @return void
     */
    public function test_weather_cached_endpoint()
    {
        // First API call to cache the data
        $this->getJson('/api/weather/Manila/cached');
        
        // Second API call should return cached data
        $response = $this->getJson('/api/weather/Manila/cached');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'status',
                    'message',
                     'data' => [
                         'city',
                         'temperature',
                         'weather_description',
                         'timestamp',
                         'source'
                     ]
                 ])
                 ->assertJsonPath('data.source', 'cache');
    }
}
