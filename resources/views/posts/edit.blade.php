@extends('layouts.admin')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('posts.update',$product[0]->product_id) }}" method="POST">
        @csrf
        @method('PUT')

<div class="tabs_menu">
@foreach($languages as $key => $lang)
<a class="a_link" href="#tab{{ $lang->lang_id }}">{{ $lang->lang_symbols }}</a>
@endforeach
</div>
         <div class="row">
		 @foreach($languages as $key => $lang)
		 @if($lang->lang_id == 1)
		 <div class="tab" id = "tab{{ $lang->lang_id }}">
         <h2> {{ $lang->lang_symbols }} </h2>		 
		   <input type="hidden" name="posts_arr[{{ $key }}][lang]" value="{{ $lang->locale }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="posts_arr[{{ $key }}][name]" value="{{ $product[$key]->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="posts_arr[{{ $key }}][detail]" placeholder="Detail">{{ $product[$key]->description }}</textarea>
                </div>
            </div>
			</div>
			@else
			<div class="tab" id = "tab{{ $lang->lang_id }}" style="display:none">
         <h2> {{ $lang->lang_symbols }} </h2>		 
		   <input type="hidden" name="posts_arr[{{ $key }}][lang]" value="{{ $lang->locale }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="posts_arr[{{ $key }}][name]" value="{{ $product[$key]->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="posts_arr[{{ $key }}][detail]" placeholder="Detail">{{ $product[$key]->description }}</textarea>
                </div>
            </div>
			</div>
			@endif
			@endforeach
			<p><select name = "cat_name[]">
			@foreach($categories as $key => $category)
			    @if($product[0]->category_id == $category->category_id)
                 <option value="{{ $category->category_id }}" selected>{{ $category->cat_name }}</option> 
                @else
				 <option value="{{ $category->category_id }}">{{ $category->cat_name }}</option> 
				@endif
			@endforeach
		    </select></p>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>
</div>
</div>
</div>

@endsection