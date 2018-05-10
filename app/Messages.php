<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'from_id', 'whom_id','message'
    ];
}
