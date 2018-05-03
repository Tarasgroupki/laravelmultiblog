<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Images;

class Album extends Model
{
  protected $table = 'albums';

  protected $fillable = array('name','description','cover_image');

  public function Photos(){

    return $this->hasMany(Images::class);
  }
}
