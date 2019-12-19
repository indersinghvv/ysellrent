<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Useraddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userid', 'address', 'city','pincode','country',
    ];
}
