<?php

namespace App\Models;

use App\Models\Admin\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'res_comment',
    ];

    /**
     * Get the options that belong to the reservation.
     *
     * @return BelongsToMany
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'option_reservation')
                    ->withPivot('by_day');
    }

    /**
     * Get the user that owns the reservation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
