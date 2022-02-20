<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Helpers\HC;
use App\Http\Controllers\Api\Helpers\Swapi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\RegisterApiRequest;
use App\Http\Resources\UserResource;
use App\Models\Film;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    public function login(LoginApiRequest $request)
    {
        $credentials = $this->checkCredentials(request(['email', 'password']));
        if ($credentials){
            return HC::rError('Invalid email or password.', 422);
        }

        $user = User::where('email', $request->email)->with(['films', 'vehicles'])->first();

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return HC::rSuccess('Logged in successfully.', 200, ['token' => $authToken, 'data' => new UserResource($user)]);
    }

    public function register(RegisterApiRequest $request)
    {
        $randomPersonId = rand(1, 30);

        $response = Swapi::fetchPersonById($randomPersonId);

        $requestData = $request->validated();

        $requestData['password'] = bcrypt($request->password);

        $mergedData = array_merge($requestData, $response);

        $user = User::create($mergedData);

        foreach($response['vehicles'] as $value)
        {
            $vehId = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            $vehicle = Swapi::fetchVehicleById($vehId);
            $vehicle = Vehicle::create($vehicle);
            $vehicle->users()->save($user);
        }

        foreach($response['films'] as $value)
        {
            $filmId = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            $film = Swapi::fetchFilmById($filmId);
            $film = Film::create($film);
            $film->users()->save($user);
        }

        return HC::rSuccess('The account has been created successfully.', 201);
    }

    private function checkCredentials(array $credentials)
    {
        if (!auth()->attempt($credentials)) {
            return true;
        }

        return false;
    }
}
