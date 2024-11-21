<?php 

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDatePrice extends Model
{
    use HasFactory;

    protected $table = 'specials_dates_prices';

    protected $fillable = [
        'spe_date', 
        'spe_price', 
    ];
}
