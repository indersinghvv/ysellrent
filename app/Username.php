<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    protected $fillable = [
        'username', 'temp_username', 'user_id',
    ];
}
