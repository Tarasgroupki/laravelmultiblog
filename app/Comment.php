<?php

namespace App;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoinTrait;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use EloquentJoinTrait;
	
	protected $table = 'comment';
    public function subcomment()
	{
		return $this->belongsTo(Comment::class,'id','parent_id');
	}
}
