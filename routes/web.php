<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$namespace = config('admin-generator.namespace');
$instances = config('admin-generator.instances', []);

foreach ($instances as $name => $instance) {

    $attributes = [
        'domain' => $instance['domain'],
        'prefix' => $instance['prefix']
    ];

    Route::group($attributes, function (Router $router) use ($namespace, $name, $instance) {
            $router->get('{slug?}', [
                'middleware' => [ 'auth' ],
                function (Request $request) use ($namespace, $name) {
                    return view("{$namespace}.{$name}.app", compact('namespace', 'name', 'request'));
                }
            ])->where('slug', '^[^~]*$');
    });
}

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/{locale}/home', 'HomeController@index')->name('home');
Route::get('/{locale}/posts', 'HomeController@blogIndex')->name('blog');
Route::get('/{locale}/posts/{id}/{slug}', 'HomeController@blogIndex')->where(['id' => '[0-9]+','slug' => '[A-Za-z0-9]+'])->name('cat_blog');
Route::get('/{locale}/post/{id}/{slug}', 'HomeController@blogView')->where(['id' => '[0-9]+','slug' => '[A-Za-z0-9]+'])->name('blog_view');
/*end of Rules links*/
Route::get('role/create','RulesController@indexCreate')->name('addRole');
Route::get('role','RulesController@index')->name('indexRole');
Route::get('role/edit/{id}','RulesController@edit')->name('editRole');
Route::get('role/{id}','RulesController@indexCreate')->where(['id' => '[0-9]+'])->name('updateRole');
Route::patch('role/create',  ['as' => 'roles.update', 'uses' => 'RulesController@create']);
Route::patch('role/update/{id}',  ['as' => 'roles.add', 'uses' => 'RulesController@update']);
Route::get('role/destroy/{id}',  ['as' => 'roles.destroy', 'uses' => 'RulesController@destroy']);
/*end of Rules links*/

/*Posts links*/
Route::get('posts/index',['as' => 'posts.index','uses' => 'PostsController@index']);
Route::get('posts/create',['as' => 'posts.create','uses' => 'PostsController@create']);
Route::get('posts/destroy/{id}',['as' => 'posts.destroy','uses' => 'PostsController@destroy']);
Route::get('posts/show/{id}',['as' => 'posts.show','uses' => 'PostsController@show']);
Route::get('posts/edit/{id}',['as' => 'posts.edit','uses' => 'PostsController@edit']);
Route::post('posts/store',['as' => 'posts.store','uses' => 'PostsController@store']);
Route::put('posts/update/{id}',['as' => 'posts.update','uses' => 'PostsController@update']);
/*end of Posts links*/

/*Categories links*/
Route::get('categories/index',['as' => 'categories.index','uses' => 'CategoriesController@index']);
Route::get('categories/create',['as' => 'categories.create','uses' => 'CategoriesController@create']);
Route::get('categories/destroy/{id}',['as' => 'categories.destroy','uses' => 'CategoriesController@destroy']);
Route::get('categories/show/{id}',['as' => 'categories.show','uses' => 'CategoriesController@show']);
Route::get('categories/edit/{id}',['as' => 'categories.edit','uses' => 'CategoriesController@edit']);
Route::post('categories/store',['as' => 'categories.store','uses' => 'CategoriesController@store']);
Route::put('categories/update/{id}',['as' => 'categories.update','uses' => 'CategoriesController@update']);
/*end of Categories links*/

/*Users links*/
Route::get('users/index',['as' => 'user.index','uses' => 'UserController@indexUser']);
Route::get('users/edit/{id}',['as' => 'user.editRoles','uses' => 'UserController@editRole']);
Route::get('users/destroy/{id}',['as' => 'user.destroy','uses' => 'UserController@destroy']);
Route::get('/{locale}/users/{user}',  ['uses' => 'UserController@edit'])->where(['locale' => '[A-Za-z]+','user' => '[0-9]+'])->name('users_edit');
Route::patch('users/update/{id}',  ['as' => 'user.add', 'uses' => 'UserController@updateRole']);
Route::patch('{locale}/users/{user}',  ['as' => 'users.update', 'uses' => 'UserController@update']);
/*end of Users links*/

/*Albums links*/
Route::get('album/{id}', array('as' => 'index','uses' => 'AlbumsController@getList'));
Route::get('albums/createalbum', array('as' => 'create_album_form','uses' => 'AlbumsController@getForm'));
Route::post('albums/createalbum', array('as' => 'create_album','uses' => 'AlbumsController@postCreate'));
Route::get('albums/deletealbum/{id}', array('as' => 'delete_album','uses' => 'AlbumsController@getDelete'));
Route::get('albums/album/{id}', array('as' => 'show_album','uses' => 'AlbumsController@getAlbum'));
/*end of Albums links*/

/*Images links*/
Route::get('images/add',['as' => 'add_image','uses' => 'AlbumsController@getAlbum']);
Route::get('images/delete/{id}',['as' => 'delete_image','uses' => 'AlbumsController@getAlbum']);
Route::get('images/main/{album}/{id}',['as' => 'main_img','uses' => 'AlbumsController@setMainImage']);
Route::post('image/upload/{id}',['as' => 'download_img','uses' => 'AlbumsController@downloadImage']);
Route::get('image/delete/{id}',['as' => 'delete_img','uses' => 'AlbumsController@deleteImage']);
/*end of Images links*/
Route::put('comments/add/{id}',['as' => 'add_comment','uses' => 'CommentsController@CommentsAdd']);
Route::put('comments/add_pr/{id}/{parent_id}',['as' => 'add_parent_comment','uses' => 'CommentsController@CommentsAdd']);
Route::put('comments/edit/{id}',['as' => 'edit_comment','uses' => 'CommentsController@CommentsEdit']);
Route::get('comments/delete/{id}',['as' => 'delete_comment','uses' => 'CommentsController@CommentsDelete']);