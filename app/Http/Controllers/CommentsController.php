<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    public function CommentsAdd($id,$parent_id = null)
	{
		DB::table('comment')->insert(
          ['user_id' => auth()->user()->id, 'content_id' => $id,'parent_id' => $parent_id,'comment' => request('comment')]
        );
		
		return back();
	}
	public function CommentsEdit($id)
	{
		DB::update('update comment set comment = ? where id = ?', [request('comment'),$id]);
		
		return back();
	}
	public function CommentsDelete($id)
	{
		DB::table('comment')->where('id', '=', $id)->delete();
		
		return back();
	}
	
}
