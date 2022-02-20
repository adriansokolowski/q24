<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model',
        'manufacturer',
        'cost_in_credits',
        'length',
        'max_atmosphering_speed',
        'crew',
        'passengers',
        'cargo_capacity',
        'consumables',
        'vehicle_class',
        'created',
        'edited'
    ];

    protected $dates = [
        'created',
        'edited',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->morphToMany(User::class, 'userable');
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
