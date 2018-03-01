<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('lang');
    }

    public function edit($locale,User $user)
    {   
        $user = Auth::user();
		$profile = DB::select('select * from profile where user_id = ?',[$user->id])[0];
		//print_r($profile[0]->user_id);die;
		$avatar = asset($profile->avatar);
        return view('users.edit', compact('profile','avatar'));
    }

    public function update($locale,User $user,Request $request)
    { 
	     $profile = DB::select('select * from profile where user_id = ?',[$user->id])[0];
         
		 $this->validate(request(),[
		     'first_name' => 'string',
			 'second_name' => 'string',
			 //'avatar' => 'mimes:jpeg,bmp,png',
			 //'birthday' => 'date'
		 ]); 
		 //$path = $request->avatar->path();
		// echo $path;
		 //var_dump($request->avatar);die;
		 if($request->hasFile('avatar')):
		 $filename = $request->avatar->getClientOriginalName();
		 //echo $filename;die;
		 $file = $request->avatar->storeAs('public',$filename);
		 //$file->move('storage',$file->getClientOriginalName());
         endif;
		DB::table('profile')->where('user_id', $user->id)->update(['first_name' => request('first_name'),'second_name' => request('second_name'),'avatar' => 'storage/'.$request->avatar->getClientOriginalName(),'birthday' => request('birthday')]);

        return back();
    }
	/*public function downloadFile($myFile)
    {
    	$myStorageFile = asset('storage/'.$myFile);
    	$headers = ['Content-Type: application/jpeg|png'];
    	$newName = 'file'.time().'.jpeg';


    	return response()->download($myStorageFile, $newName, $headers);
    }*/
	/*public function setUserRoles()
	{
		$this->validate(request(),[
		     'role_name' => 'string'
		 ]); 
		$user = Auth::user();
		$user->assignRole(request('role_name'));
		$role = Role::create(['name' => 'writer']);
        $permission = Permission::create(['name' => 'edit articles']);
		
	} */
	public function indexUser()
	{
		$users = User::get();
		return view('users.index', compact('users'));
	}
	public function editRole($id)
	{
		$roles_all = Role::get();
		foreach($roles_all as $key => $role):
		$roles[$key] = $roles_all[$key]->getOriginal();
		endforeach;
        $roles_ids = DB::select('select * from model_has_roles where model_id = ?',[$id]);
        foreach($roles_ids as $key => $ids):
        $roles_id[$ids->role_id] = $ids;
        endforeach;
		//print_r($roles);die;
		return view('users.editRoles', compact('id','roles','roles_id'));
	}
	public function updateRole(Request $request, $id)
    {
		$user = User::find($id);
		if(request('selected_roles') !== null):
		$ids[0] = implode(request('selected_roles'),"','");
		endif;
		if(request('roles') !== null):
		$ids[1] = implode(request('roles'),"','");		
		foreach(request('roles') as $key => $roles):
		$user->assignRole($roles);
		endforeach;
		endif;
		$ids = implode($ids,"','");
		$ids = "'".$ids."'";
		$user_ids = DB::select("select * from roles where name NOT IN($ids)");
		foreach($user_ids as $key => $role):
		$user->removeRole($role->name);
		endforeach;
		return back();
    }
}