<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'height',
        'mass',
        'hair_color',
        'skin_color',
        'eye_color',
        'birth_year',
        'gender',
        'created',
        'edited'
    ];

    protected $dates = [
        'created',
        'edited',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function films()
    {
        return $this->morphedByMany(Film::class, 'userable');
    }

    public function vehicles()
    {
        return $this->morphedByMany(Vehicle::class, 'userable');
    }

    public function getCreatedAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function getEditedAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    public function setCreatedAttribute($value)
    {
        $this->attributes['created'] = $value ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $value)->format('Y-m-d H:i:s') : null;
    }

    public function setEditedAttribute($value)
    {
        $this->attributes['edited'] = $value ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $value)->format('Y-m-d H:i:s') : null;
    }
}
