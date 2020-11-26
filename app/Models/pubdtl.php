<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pubdtl extends Model
{
    use HasFactory;

    protected $fillable = [
        'slno','pubhdrid','athrfirstname','athrmiddlename','athrlastname','inhouseflag'
    ];

    public function pubhdrs(){
        return $this->belongsTo('App\pubhdr','id');
    }
}
