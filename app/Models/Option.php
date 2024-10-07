<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'available', 
        'preselected', 
        'by_day', 
        'by_day_display', 
        'by_day_preselected',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'option_reservation');
    }
}
