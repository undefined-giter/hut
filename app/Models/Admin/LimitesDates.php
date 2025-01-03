<?php 

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitesDates extends Model
{
    use HasFactory;

    protected $table = 'limites_dates';

    protected $fillable = [
        'minDate', 
        'maxDate', 
    ];
}
