<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$album->name}}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!-- Latest compiled and minified CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<style>
      body {
        padding-top: 50px;
      }
      .starter-template {
        padding: 40px 15px;
        text-align: center;
      }
	  #modal-upload.modal-dialog{
		  width: 800px!important;
	  }
    </style>
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <button type="button" class="navbar-toggle"data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Awesome Albums</a>
        <div class="nav-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="{{URL::route('create_album_form')}}">Create New Album</a></li>
          </ul>
        </div><!--/.nav-collapse -->
     </div>
    </div>
    <div class="container">
    
      <div class="starter-template">
        <div class="media">
          <img class="media-object pull-left"alt="{{$album->name}}" src="/albums/{{$album->cover_image}}" width="350px">
          <div class="media-body">
			<h2 class="media-heading" style="font-size: 26px;">Album Name:</h2>
            <p>{{$album->name}}</p>
          <div class="media">
          <h2 class="media-heading" style="font-size: 26px;">AlbumDescription:</h2>
          <p>{{$album->description}}<p> 
        </div>
		<a href="#" data-toggle="modal" data-target="#modal-upload" role="button" class="btn btn-primary btn-large">Add New Image to Album</a>
          <a href="{{URL::route('delete_album',array('id'=>$album->id))}}" onclick="return confirm('Are yousure?')"><button type="button"class="btn btn-danger btn-large">Delete Album</button></a>
      </div>
    </div>
    </div>
      <div class="row">
        @foreach($album->Photos as $photo)
          <div class="col-lg-3">
            <div class="thumbnail" style="max-height: 350px;min-height: 350px;">
              <img alt="{{$album->name}}" src="/storage/images/{{$photo->image}}">
              <div class="caption">
                <p>{{$photo->description}}</p>
                <p><p>Created date:  {{ date("d F Y",strtotime($photo->created_at)) }} at {{ date("g:ha",strtotime($photo->created_at)) }}</p></p>
                <a href="{{URL::route('delete_img',array('id' => $photo->id))}}" onclick="return confirm('Are you sure?')"><button type="button" class="btnbtn-danger btn-small">Delete Image </button></a>
				<a href="{{URL::route('main_img',['album' => $album->id,'id' => $photo->id])}}" ><button type="button" class="btn btn-primary btn-small">Make Main </button></a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

{{-- Confirm Upload --}}
    <div  class="modal fade" id="modal-upload" role="dialog">
      <div style="position:absolute;right:750px;top:350px;" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              ×
            </button>
            <h4 class="modal-title">Please Confirm</h4>
          </div>
          <div class="modal-body">
            <p class="lead">
              <i class="fa fa-question-circle fa-lg"></i>  
			  <form style="position:relative;" method="post" action="{{route('download_img', ['id' => $album->id])}}" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
	<div class="form-group row">
<label for="image" class="col-md-4 col-form-label text-md-right">File</label>
<div class="col-md-6">
    <input type="file" name="image" />
</div>
</div>
<div class="form-group row">
<label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
<div class="col-md-6">
    <input type="text" name="description" placeholder="|Description of image"/>
</div>
</div>

<div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Send</button>
								</div>
								</div>
	</form>
            </p>
          </div>
          <div class="modal-footer">
		  Hello World!
          </div>
        </div>
      </div>
    </div>
	<script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>