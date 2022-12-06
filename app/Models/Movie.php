<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * @mixin IdeHelperMovie
 */
class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'genre',
        'length',
        'image_url',
    ];

    public function halls(): BelongsToMany
    {
        return $this->belongsToMany(Hall::class);
    }
}
