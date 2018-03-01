<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
		$this->middleware('lang');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
	public function blogIndex($locale,$id = null)
	{
	$user = Auth::user();
	//print_r($user->getRoleNames());
	    if($id == null):
		$posts = DB::select('select * from posts where locale = ?',[$locale]);
		else:
		$posts = DB::select('select * from posts where locale = ? && category_id = ?',[$locale,$id]);
		endif;
		$categories = DB::select('select * from categories where locale = ?',[$locale]);
		return view('blog.index',['posts' => $posts,'categories' => $categories]);
	}
	public function blogView($locale,$id)
	{
	//print_r(route()->getId());die;
		$post = DB::select('select * from posts where product_id = ? && locale = ?', [$id,$locale]);
		
		return view('blog.view',['post' => $post[0]]);
	}
}
