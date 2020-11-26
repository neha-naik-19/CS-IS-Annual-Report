<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pubhdr extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','authortypeid','broadareaid','categoryid','nationality', 'confname','description',
            'impactfactor','place','pubdate','rankingid','title','articletypeid','volume','issue',
            'pp','digitallibrary'
    ];
}
