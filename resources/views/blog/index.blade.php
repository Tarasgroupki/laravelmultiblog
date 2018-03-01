@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Posts</div>
				
				<div class="card-body">
				     @foreach ($categories as $category)
                         <p><a href="{{ route('cat_blog',['locale' => Route::current()->parameters()['locale'],'uid' => $category->category_id,'uslug' => str_slug($category->cat_name)]) }}">{{ $category->cat_name }}</a></p>
                     @endforeach
				</div>
       
	            <div class="card-body">
				     @foreach ($posts as $post)
                         <p>Name: <a href="{{ route('blog_view',['locale' => Route::current()->parameters()['locale'],'id' => $post->product_id,'slug' => str_slug($post->name)]) }}">{{ $post->name }}</a></p>
						 <p>Description: {{ $post->description }}</p>
                     @endforeach
				</div>
               
            </div>
        </div>
    </div>
</div>
@endsection
