<?php

namespace App\Models;

use App\Models\Route;
use App\Models\BusSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusSchedule extends Model
{
    use HasFactory;

    public $fillable = [
        'bus_id',
        'route_id',
        'departure_time',
        'arrival_time',
        'date',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class); 
    }

    public function bus() :HasMany
    {
        return $this->hasMany(Bus::class);
    }
}
