<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use HasFactory;

    public $guarded = [];
}
