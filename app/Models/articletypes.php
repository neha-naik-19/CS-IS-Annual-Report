<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articletypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'articleid','article','journalconfernce'
    ];
}
