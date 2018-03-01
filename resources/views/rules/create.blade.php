@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Rules</div>
<div class="card-body">
<form method="post" action="{{route('addRole')}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}
	<div class="form-group row">
	<label for="role_name" class="col-md-4 col-form-label text-md-right">Role Name:</label>
<div class="col-md-6">
    <input type="text" name="role_name" />
</div>
</div>
<div class="card-body">
				     @foreach ($perms as $permission)
                         <p><input type="checkbox" name="permissions[]" value="{{ $permission['name'] }}" />{{ $permission['name'] }}</p>
                     @endforeach
				</div>
<div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Save</button>
								</div>
								</div>
	
</form>
</div>
</div>
            </div>
        </div>
    </div>
@endsection