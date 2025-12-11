# Weather API (Laravel 12)

A small Laravel project to fetch real-time weather data from OpenWeatherMap API.  
Includes caching, API resource responses, and unit/feature tests.

---

## Requirements

- PHP 8.1+  
- Composer  
- Laravel 12  
- MySQL (optional, if you want to persist any data)  
- GuzzleHTTP (for external API requests)

---

## Installation

1. **Clone the repository:**

    git clone git@github.com:kentdayrit/weather_api.git
    cd weather_api

2. **Install dependencies:**

    composer install

3. **Create environment file:**

    cp .env.example .env

4. **Generate application key:**

    php artisan key:generate

5. **Set up the OpenWeather API key**

- Register for a free API key at [OpenWeatherMap](https://openweathermap.org/api).  
- Add the key to your `.env` file:

OPENWEATHER_KEY=your_api_key_here

6. **Configure services.php (optional):**

    // config/services.php
    'openweather' => [
        'key' => env('OPENWEATHER_KEY'),
    ],

7. **Running the Project:**

    php artisan serve

    By default, it will run at http://127.0.0.1:8000.