<?php

namespace App\Models;

use App\Models\Bus;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Seat;
use App\Models\BusSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory/** ,SoftDeletes*/;

    protected $fillable = [
        'total_seats',
    ];

    // protected $attributes = [
    //     'available_seats' => 'total_seats',
    // ];


    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    } 

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(BusSchedule::class);
    }

}
