<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Album;
use App\Images;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AlbumsController extends Controller
{
     public function getList($id)
  {
    $albums = Album::with('Photos')->where(['post_id' => $id])->get();
    return view('albums.index',['albums' => $albums]);
  }
  public function getAlbum($id)
  {
    $album = Album::with('Photos')->find($id);
    return view('albums.album',['album' => $album]);
  }
  public function getForm()
  {
    return view('albums.createalbum');
  }
  public function postCreate()
  {
    $rules = array(

      'name' => 'required',
      'cover_image'=>'required|image'

    );
    
    $validator = Validator::make(Input::all(), $rules);
    if($validator->fails()){

      return Redirect::route('create_album_form')
      ->withErrors($validator)
      ->withInput();
    }

    $file = Input::file('cover_image');
    $random_name = str_random(8);
    $destinationPath = 'albums/';
    $extension = $file->getClientOriginalExtension();
    $filename = $random_name.'_cover.'.$extension;
    $uploadSuccess = Input::file('cover_image')
    ->move($destinationPath, $filename);
    $album = Album::create(array(
      'name' => Input::get('name'),
      'description' => Input::get('description'),
      'cover_image' => $filename,
    ));

    return Redirect::route('show_album',array('id'=>$album->id));
  }

  public function getDelete($id)
  {
    $album = Album::find($id);

    $album->delete();

    return Redirect::route('index');
  }
  public function setMainImage($album_id,$id)
  {
	  $image = Images::find($id);
	  $filename = $image->image;
	  Album::find($album_id)->update(['cover_image' => $filename]);
	  $image_path = 'storage/images/'.$filename.''; 
	  $album_path = 'albums/'.$filename.'';	  
	  copy($image_path, $album_path);
	  
	  return back();
  }
  public function downloadImage($id,Request $request)
  {
	  if($request->hasFile('image')):
	  $random_name = str_random(8);
      $destinationPath = 'storage/images/';
	  $file = $request->image;
	  $extension = $file->getClientOriginalExtension();
	  $filename = $random_name.'_img.'.$extension;
	  $file->storeAs('public/images/',$filename);
	  $image = Images::create(array(
	  'album_id' => $id,
      'image' => $filename,
      'description' => request('description')
    ));
	  endif;
	  
	  return back();
  }
  public function deleteImage($id)
  {
	  $image = Images::find($id);
	  unlink('storage/images/'.$image->image);
	  $image->delete();
	  
	  return back();
  }
}
