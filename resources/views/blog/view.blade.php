@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Posts</div>
       
	            <div class="card-body">
				      <p>Name: {{ $post->name }}</p>
					  <p>Description: {{ $post->description }}</p>
					{{ $post->product_id }}
					@include('comments::comments-react', [
    'content_type' => App\Posts::class,
    'content_id' =>  $post->product_id 
])
				</div>
               
            </div>
        </div>
    </div>
</div>
@endsection