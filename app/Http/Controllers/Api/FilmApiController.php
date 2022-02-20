<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Helpers\HC;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilmResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FilmApiController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $user = User::where('id', $userId)->first();

        $cached = Redis::get('filmRes_' .$userId);

        if ($cached) return HC::rSuccess("Get from cache.", 200, json_decode($cached, TRUE));

        Redis::set('filmRes_' .$userId, json_encode(FilmResource::collection($user->films), FALSE), 'EX', 24 * 60 * 60);

        return HC::rSuccess("Get from database.", 200, FilmResource::collection($user->films));
    }
}
