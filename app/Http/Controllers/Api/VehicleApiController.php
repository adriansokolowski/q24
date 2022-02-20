<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Helpers\HC;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Http;

class VehicleApiController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $user = User::where('id', $userId)->first();

        $cached = Redis::get('vehicleRes_' .$userId);

        if ($cached) return HC::rSuccess("Get from cache.", 200, json_decode($cached, TRUE));

        Redis::set('vehicleRes_' .$userId, json_encode(VehicleResource::collection($user->vehicles), FALSE), 'EX', 24 * 60 * 60);

        return HC::rSuccess("Get from database.", 200, VehicleResource::collection($user->vehicles));
    }
}
