@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Rules for user</div>
<div class="card-body">
<form method="post" action="{{route('user.add',$id)}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}
<div class="card-body">
				     @foreach ($roles as $key => $role)
                     @if(isset($roles_id[$role['id']]))                  
                         <p><input type="checkbox" name="selected_roles[]" value="{{ $role['name'] }}" checked="checked"/>{{ $role['name'] }}</p>
                       @else 
                         <p><input type="checkbox" name="roles[]" value="{{ $role['name'] }}" />{{ $role['name'] }}</p>
                       @endif
                     
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