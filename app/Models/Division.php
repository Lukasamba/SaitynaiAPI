<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * @mixin IdeHelperDivision
 */
class Division extends Model
{
    use HasFactory, HasSnowflakePrimary, SoftDeletes;

    protected $fillable = [
        'address',
        'halls_count',
    ];
}
