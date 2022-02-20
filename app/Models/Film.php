<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'episode_id',
        'opening_crawl',
        'director',
        'producer',
        'release_date',
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
