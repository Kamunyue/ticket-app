<?php

namespace App\Models;

use App\Models\User;
use App\Models\BusSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_location',
        'arrival_location',
        'fare',
    ];

    public function schedule(): HasMany
    {
        return $this->hasMany(BusSchedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
