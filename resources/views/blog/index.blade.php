@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Posts</div>
				
				<div class="card-body">
			    <ul>
@foreach($categories as $category)
        <li><p><a href="{{ route('cat_blog',['locale' => Route::current()->parameters()['locale'],'uid' => $category->category_id,'uslug' => str_slug($category->cat_name)]) }}">{{ $category->cat_name }}</a></p>
            @if(count( $category->subcategory) > 0 )
                <ul>
                    <li><p><a href="{{ route('cat_blog',['locale' => Route::current()->parameters()['locale'],'uid' => $category->subcategory->getAttributes()['category_id'],'uslug' => str_slug($category->subcategory->getAttributes()['cat_name'])]) }}">{{ $category->subcategory->getAttributes()['cat_name'] }}</a></p></li>

                </ul>
            @endif
        </li>                   
@endforeach
</ul>
				</div>
       
	            <div class="card-body">
				     @foreach ($posts as $post)
					 <img style="height:200px;width:300px" src="/albums/{{ $post->cover_image }}"><br />
                         <p>Name: <a href="{{ route('blog_view',['locale' => Route::current()->parameters()['locale'],'id' => $post->product_id,'slug' => str_slug($post->name)]) }}">{{ $post->name }}</a></p>
						 <p>Description: {{ $post->description }}</p>
                     @endforeach
				</div>
               
            </div>
        </div>
    </div>
</div>
@endsection
