<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WeatherResource
 *
 * Transforms a WeatherData object into an API response array.
 *
 * @package App\Http\Resources
 *
 * @property string $city
 * @property float|null $temperature
 * @property string|null $weather_description
 * @property int|string $timestamp
 * @property string $source
 */
class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'city' => $this->city,
            'temperature' => $this->temperature,
            'weather_description' => $this->weather_description,
            'timestamp' => $this->timestamp,
            'source' => $this->source,
        ];
    }
}
