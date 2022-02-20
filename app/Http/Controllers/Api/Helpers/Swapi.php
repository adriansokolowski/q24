<?php
namespace App\Http\Controllers\Api\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class Swapi extends Controller
{
    private static $cacheTime = 24 * 60 * 60;

    public static function fetchPersonById(int $id) :array
    {
        $cached = Redis::get('people_' .$id);
        if ($cached) return json_decode($cached, TRUE);
        $result = Http::get('https://swapi.dev/api/people/'. $id)->json();
        Redis::set('people_' . $id, json_encode($result, FALSE), 'EX', self::$cacheTime);

        return $result ?? null;
    }

    public static function fetchVehicleById(int $id) :array
    {
        $cached = Redis::get('vehicle_' .$id);
        if ($cached) return json_decode($cached, TRUE);
        $result = Http::get('https://swapi.dev/api/vehicles/' .$id)->json();
        Redis::set('vehicle_' . $id, json_encode($result, FALSE), 'EX', self::$cacheTime);

        return $result ?? null;
    }

    public static function fetchFilmById(int $id) :array
    {
        $cached = Redis::get('film_' .$id);
        if ($cached) return json_decode($cached, TRUE);
        $result = Http::get('https://swapi.dev/api/films/'. $id)->json();
        Redis::set('film_' . $id, json_encode($result, FALSE), 'EX', self::$cacheTime);

        return $result ?? null;
    }
}
