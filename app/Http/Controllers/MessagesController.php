<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MessagesController extends Controller
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
        $users = DB::table('users')->where('id','!=',Auth::user()->id)->get();
        //print_r($users);die;
        return view('messages.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Messages::create(array(
            'from_id' => Input::post('from_id'),
            'whom_id' => Input::post('whom_id'),
            'message' => Input::post('message'),
            'is_delete_from' => null,
            'is_delete_whom' => null
        ));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show($id,Messages $messages)
    {
        $from = Auth::user();
        $whom = DB::table('users')->where('id',$id)->get()[0];
        $fromAvatar = asset(DB::table('profile')->where('user_id',$from->id)->get()[0]->avatar);
        $whomAvatar = asset(DB::table('profile')->where('user_id',$whom->id)->get()[0]->avatar);
        $messages = DB::table('messages')->where([
            ['from_id', '=', $from->id],
            ['whom_id', '=', $whom->id],
        ])
        ->orwhere([
            ['from_id', '=', $whom->id],
            ['whom_id', '=', $from->id],
        ])->get();

        return view('messages.view', ['from' => $from,'whom' => $whom,'fromAvatar' => $fromAvatar,'whomAvatar' => $whomAvatar,
        'messages' => $messages]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Messages $messages)
    {
        DB::update('update messages set is_delete_from = ? where id = ?',[$id,$id]);

        return back();
    }
}
