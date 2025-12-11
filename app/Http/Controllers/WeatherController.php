<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\WeatherResource;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherController extends Controller
{
    public function __construct(
        private readonly WeatherService $weatherService
    )
    {}
    
    /**
     * Return weather data from the external API.
     */

    public function show(string $city)
    {
        try {
            $weatherData = $this->weatherService->getCityWeather($city);
            $weatherData->source = 'external';

            return ApiResponse::success(
                data: new WeatherResource((object) $weatherData),
                status: 200
            );
            
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Something Went Wrong',
                status: 500,
                errors: [$e->getMessage()]
            );
        }
    }
    
    /**
     * Return weather data, cached for 10 minutes.
     */
    public function showCached(string $city)
    {
        try {
            $cacheKey = "weather_{$city}";
            $isCached = Cache::has($cacheKey);
            $weatherData = Cache::remember($cacheKey, 600, function () use ($city) {
                return $this->weatherService->getCityWeather($city, false);
            });
            $weatherData->source = $isCached ? 'cache' : 'external';

            return ApiResponse::success(
                data: new WeatherResource((object) $weatherData),
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Something Went Wrong',
                status: $e instanceof HttpException ? $e->getStatusCode() : 500,
                errors: [$e->getMessage()]
            );
        }
    }
}
