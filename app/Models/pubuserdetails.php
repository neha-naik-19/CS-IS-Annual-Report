<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pubuserdetails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'pubid','type','updated_date','updated_time'
    ];
}
