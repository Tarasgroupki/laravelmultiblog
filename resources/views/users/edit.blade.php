@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Profile</div>
<div class="card-body">
<img src="{{ $avatar }}" style="height:250px;weight:250px;"/>
<form method="post" action="{{route('users_edit', ['locale' => App::getLocale(),'profile' => $profile->user_id])}}" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('patch') }}
	<div class="form-group row">
	<label for="first_name" class="col-md-4 col-form-label text-md-right">Username</label>
<div class="col-md-6">
    <input type="text" name="first_name"  value="{{ $profile->first_name }}" />
</div>
</div>
<div class="form-group row">
<label for="second_name" class="col-md-4 col-form-label text-md-right">E-mail</label>
<div class="col-md-6">
    <input type="text" name="second_name"  value="{{ $profile->second_name }}" />
</div>
</div>
<div class="form-group row">
<label for="birthday" class="col-md-4 col-form-label text-md-right">Password</label>
<div class="col-md-6">
    <input type="date" name="birthday"  value="{{ $profile->birthday }}"/>
</div>
</div>
<div class="form-group row">
<label for="avatar" class="col-md-4 col-form-label text-md-right">Password</label>
<div class="col-md-6">
    <input type="file" name="avatar" />
</div>
</div>
<div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Send</button>
								</div>
								</div>
	
</form>
</div>
</div>
            </div>
        </div>
    </div>
@endsection