<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Comments\Traits\Comments;

class Posts extends Model
{
    use Comments;    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'detail'
    ];
}
