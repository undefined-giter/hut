<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'nights',
        'res_price',
        'status',
    ];

    public function options()
    {
        return $this->belongsToMany(Option::class, 'option_reservation');
    }
}
