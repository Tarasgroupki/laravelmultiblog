<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use App\User;
use App\Posts;
use App\Comment;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Spatie\Permission\Models\Permission;
use Illuminate\Pagination\Paginator;
use Socialite;

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
	public function blogIndex($locale = "en",$id = null)
	{
	    if($id == null):
		/*$posts = DB::select('select p.*,a.cover_image from posts AS p JOIN albums AS a ON p.product_id = a.post_id where p.locale = ?',[$locale]);*/
		$posts = Posts::query()->select(['posts.*','albums.cover_image'])->join('albums','posts.product_id','=','albums.post_id')->where('posts.locale',$locale)->paginate(5);
		//print_r($posts);die;
		else:
		$parent_id = DB::select('select category_id from categories where locale = ? && (parent_id = ? || category_id = ?)',[$locale,$id,$id]);
		foreach($parent_id as $key => $id):
		  $par_id[$key] = (string)($id->category_id);
		endforeach;
		$parent_ids = implode($par_id,',');
		/*$posts = DB::select("select p.*,a.cover_image from posts AS p JOIN albums AS a ON p.product_id = a.post_id where locale = ? && category_id IN($parent_ids)",[$locale]);*/
		$posts = Posts::query()->select(['posts.*','albums.cover_image'])->join('albums','posts.product_id','=','albums.post_id')->where('posts.locale',$locale)->whereIn('category_id',[$parent_ids])->paginate(5);
		endif;
		$categories = \App\Categories::where('parent_id', null)->where('locale',$locale)->get();
		return view('blog.index',['posts' => $posts,'categories' => $categories]);
	}
	public function blogView($locale,$id)
	{
	    $images = DB::select('select `image` from albums AS a JOIN images as b ON a.id = b.album_id where a.post_id = ?',[$id]);
		$post = DB::select('select * from posts where product_id = ? && locale = ?', [$id,$locale]);
		$count = Comment::where('parent_id','!=',null)->count();
		$comments = Comment::join('profile',function($join){
			$join->on('comment.user_id', '=', 'profile.user_id');
		})->where('parent_id',null)->get();
		
		
		return view('blog.view',['post' => $post[0],'images' => $images,'comments' => $comments,'count' => $count]);
	}
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {//die;
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
       $user = Socialite::driver('github')->user();
$user_token = User::where('email',$user->getEmail())->get();
if(!isset($user_token[0])):
        User::create([
            'name' => $user->getNickname(),
            'email' => $user->getEmail(),
            'remember_token' => $user->token,
            'password' => '',
        ]);
    $user_token = User::where('email',$user->getEmail())->get();
    DB::table('profile')->insert(
        ['user_id' => $user_token[0]->id, 'first_name' => '','second_name' => '','avatar' => $user->getAvatar(),'birthday' => date("Y-m-d")]
    );
endif;
       Auth::loginUsingId($user_token[0]->id);
     //  echo $user->token;
     //  echo $user->getId();
     //  echo $user->getNickname();
     //  echo $user->getName();
     //  echo $user->getEmail();
     //  die;
        return redirect('');
    }

}
