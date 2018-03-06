<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RulesController extends Controller
{
	 public function __construct()
    {
        //$this->middleware('auth');
		$this->middleware('role_admin');
		//$this->middleware('lang');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $roles = Role::get();
	  // print_r($roles);die;
	   return view('rules.index',compact('roles'));
    }

	public function indexCreate($locale,$id = null)
	{
		$permissions = Permission::get();
		foreach($permissions as $key => $permission):
		$perms[$key] = $permissions[$key]->getOriginal();
		endforeach;
		$rules = null;
		if($id != null):
		$rules = DB::select('select * from role_has_permissions where role_id = ?',[$id]);
		endif;
		//print_r($perms);die;
		return view('rules.create',compact('perms','rules'));
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validate(request(),[
		     'role_name' => 'string|required',
		 ]); 
		$role = Role::create(['name' => request('role_name')]);
		foreach(request('permissions') as $key => $perms):
		$role->givePermissionTo($perms);
		endforeach;
		return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        //print_r($role);die;
        $permissions = Permission::get();
		foreach($permissions as $key => $permission):
		$perms[$key] = $permissions[$key]->getOriginal();
		endforeach;
        $perms_ids = DB::select('select * from role_has_permissions where role_id = ?',[$id]);
        foreach($perms_ids as $key => $ids):
        $perms_id[$ids->permission_id] = $ids;
        endforeach;        
//print_r($perms_id);die;
        return view('rules.update',compact('role','perms','perms_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(),[
		     'role_name' => 'string|required',
		 ]); 
		DB::update('update roles set name = ? where id = ?', [request('role_name'),$id]);
		$role = Role::find($id);
		if(request('selected_permissions') !== null):
		$ids[0] = implode(request('selected_permissions'),"','");
		endif;
		if(request('permissions') !== null):
		$ids[1] = implode(request('permissions'),"','");
		foreach(request('permissions') as $key => $perms):
		$role->givePermissionTo($perms);
		endforeach;
		endif;
		$ids = implode($ids,"','");
		$ids = "'".$ids."'";
		$role_ids = DB::select("select * from permissions where name NOT IN($ids)");
		foreach($role_ids as $key => $permission):
		$role->revokePermissionTo($permission->name);
		endforeach;
		return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('roles')->where('id', '=', $id)->delete();
        DB::table('role_has_permissions')->where('role_id', '=', $id)->delete();
        DB::table('model_has_roles')->where('role_id', '=', $id)->delete();
        return back();
    }
}
