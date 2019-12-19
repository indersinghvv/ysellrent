<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usercarddetails extends Model
{
    protected $fillable = [
        'userid', 'cardnumber', 'cardmonth','cardyear','cardholdername'
    ];
}
