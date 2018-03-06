<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
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
        $categories = Categories::where(['locale' => 'en'])->paginate(5);


        return view('categories.index',compact('categories'))
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
        return view('categories.create',compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		request()->validate([
            //'posts_arr.*' => 'required_unless:type_of_content,is_information',
            "categories_arr.*.name" => 'required|string',
			"categories_arr.*.detail" => 'required|text',
		 ]);
        $category_id = Categories::max('category_id') + 1;
		foreach($request->categories_arr as $key => $categories):
	    DB::table('categories')->insert(
          ['category_id' => $category_id, 'parent_id' => 0,'locale' => $categories['lang'],'cat_name' => $categories['name'],'cat_description' => $categories['detail']]
        );
        endforeach;
        return redirect()->route('categories.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Categories $categories)
    {
        $languages = DB::select('select * from languages');
		$category = Categories::where(['category_id' => $id])->get();
		//print_r($product);die;
        return view('categories.edit',compact('languages','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
		request()->validate([
            //'posts_arr.*' => 'required_unless:type_of_content,is_information',
            "categories_arr.*.name" => 'required|string',
			"categories_arr.*.detail" => 'required|text',
		 ]);
       foreach($request->categories_arr as $key => $categories):
	   DB::update('update categories set cat_name = ?,cat_description = ? where category_id = ? and locale = ?', [$categories['name'],$categories['detail'],$id,$categories['lang']]);
       endforeach;

        return redirect()->route('categories.index')
                        ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('categories')->where('category_id', '=', $id)->delete();


        return redirect()->route('categories.index')
                        ->with('success','Product deleted successfully');
    }
}
