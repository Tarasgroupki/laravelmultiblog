<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('lang');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Posts::where(['locale' => 'en'])->paginate(5);


        return view('posts.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$languages = DB::select('select * from languages');
		$categories = DB::select('select * from categories where locale = ?',['en']);
		//print_r($categories);die;
        return view('posts.create',compact('languages','categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$product_id = Posts::max('product_id') + 1;
		//print_r($request->posts_arr);die;
		//foreach($request->name as $key => $name):
        request()->validate([
            "posts_arr.*.name" => 'required|string',
			"posts_arr.*.detail" => 'required',
        ]);
		//endforeach;
        //Posts::create($request->all());
       foreach($request->posts_arr as $key => $posts):
	   DB::table('posts')->insert(
          ['product_id' => $product_id, 'category_id' => $request->cat_name[0],'locale' => $posts['lang'],'name' => $posts['name'],'description' => $posts['detail']]
       );
       endforeach;
        return redirect()->route('posts.index')
                        ->with('success','Product created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $product)
    {
        return view('posts.show',compact('product'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Posts $product)
    {
		$languages = DB::select('select * from languages');
		$product = Posts::where(['product_id' => $id])->get();
		$categories = DB::select('select * from categories where locale = ?',['en']);
		//print_r($product);die;
        return view('posts.edit',compact('languages','product','categories'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {//echo $id;die;

         request()->validate([
            //'posts_arr.*' => 'required_unless:type_of_content,is_information',
            "posts_arr.*.name" => 'required|string',
			"posts_arr.*.detail" => 'required',
		 ]);
    
//print_r($request->posts_arr);die;
        //$product->update($request->all());
       foreach($request->posts_arr as $key => $posts):
	   DB::update('update posts set category_id = ?, name = ?,description = ? where product_id = ? and locale = ?', [$request->cat_name[0],$posts['name'],$posts['detail'],$id,$posts['lang']]);
       endforeach;

        return redirect()->route('posts.index')
                        ->with('success','Product updated successfully');
    }

public function rules($arr)
{
   

    return $rules;
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$product->delete();
DB::table('posts')->where('product_id', '=', $id)->delete();


        return redirect()->route('posts.index')
                        ->with('success','Product deleted successfully');
    }
}
