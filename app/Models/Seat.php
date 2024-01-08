<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seat extends Model
{
    use HasFactory;
    protected $fillable = [
        'bus_id',
        'seat_number'
    ];

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    // public function ticket(): BelongsTo
    // {
    //     return $this->belongsTo(Ticket::class);
    // }
}
