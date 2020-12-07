<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rankings extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','ranking'
    ];
}
