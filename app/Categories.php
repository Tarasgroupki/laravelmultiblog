<?php

namespace App;

use App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function subcategory()
    {
        return $this->belongsTo(Categories::class,'category_id','parent_id')->where([
		   'locale' => (App::getLocale()) ? App::getLocale() : "en",
		]);
    }
	/*public function products()
{
    return $this->hasManyThrough('App\Posts', 'App\Categories', 'parent_id', 'category_id', 'category_id');
}*/
}
