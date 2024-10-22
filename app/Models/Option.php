<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * The reservations that belong to the option.
     *
     * @return BelongsToMany
     */
    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'option_reservation');
    }
}
