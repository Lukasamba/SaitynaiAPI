<?php

namespace App\Models;

use Database\Factories\HallFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * @method static HallFactory factory(...$parameters)
 * @mixin IdeHelperHall
 */
class Hall extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'division_id',
        'name',
        'seats_count',
    ];

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
