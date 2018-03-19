@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Posts</div>
             @foreach($images as $image)
			    <img src="/storage/images/{{ $image->image }}" style="height:200px;width:200px;">
			 @endforeach
	            <div class="card-body">
				      <p>Name: {{ $post->name }}</p>
					  <p>Description: {{ $post->description }}</p>
					{{ $post->product_id }}
					@include('comments::comments-react', [
    'content_type' => App\Posts::class,
    'content_id' =>  $post->product_id 
])
				</div>
				@if(Auth::user()->id)
					<form action="{{ route('add_comment',$post->product_id) }}" method="post">
				@method('PUT')
                @csrf
						Nickname:{{ Auth::user()->name }}
						<br />
						Add a comment:
						<br />
						<textarea name="comment"></textarea>
						<br />
						<div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
				    </form>
				@endif
               <div class="comments">
			   @foreach($comments as $comment)
			   <table>
		<tbody>
			    
				<tr data-id = '{{ $comment->id }}' class="values">
				<td><img style="height:50px;width:50px;" src="/{{ $comment->avatar }}"></td>
                <td>{{ $comment->first_name }}</td>
                <td>{{ $comment->comment }}</td>
            </tr>
			<tr class="field">
			<td>
				<form data-key='{{ $comment->id }}' method="post" action="{{ route('edit_comment',$comment->id) }}">
				@method('PUT')
                @csrf
				Nickname:{{ $comment->first_name }}
				  <p><img style="height:50px;width:50px;" src="/{{ $comment->avatar }}"></p>
				  <input type="hidden" name="username" value="{{ $comment->first_name }}" />
				  <br />
				  Comment:<textarea name="comment">{{ $comment->comment }}</textarea>
				  <br />
				  <a href=""><input type="submit" name="submit" value="Post comment" /></a>
				  <input data-value='{{ $comment->id }}' class="answer" type="button" name="answer" value="Answer" />
			      <input data-value='{{ $comment->id }}' class="cancel" type="button" name="cancel" value="Cancel" />
			</form>
			<form data-parent='{{ $comment->id }}' action="{{ route('add_parent_comment', ['id' => $post->product_id,'parent_id' => $comment->id]) }}" method="post">
				@method('PUT')
                @csrf
						Nickname:{{ Auth::user()->name }}
						<br />
						Add a comment:
						<br />
						<textarea name="comment"></textarea>
						<br />
						<div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary" name="submit" value="Post comment">Submit</button>
			  <input data-value='{{ $comment->id }}' class="cancel_parent" type="button" name="cancel" value="Cancel" />
            </div>
		    </form>
			</td>
			<td>
			@if(Auth::user()->id)
                    <ul>
                        <li data-value='{{ $comment->id }}' class="edit" value='{{ $comment->id }}'>
                           edit
                        </li>
						<li>
                            <a href="{{ route('delete_comment',$comment->id) }}">delete</a>
                        </li>
                    </ul>@endif
                </td>
			</tr>	
				</tbody>
				</table>
				@for($i = 0;$i < $count;$i++)
					
				@if($comment->subcomment != null)
				 <table style="position:relative;left:100px;">
		<tbody>
			    
				<tr data-id = '{{ $comment->subcomment->getAttributes()["id"] }}' class="values">
				<td><img style="height:50px;width:50px;" src="/{{ $comment->avatar }}"></td>
                <td>{{ $comment->first_name }}</td>
                <td>{{ $comment->subcomment->getAttributes()["comment"] }}</td>
            </tr>
			<tr class="field">
			<td>
				<form data-key='{{ $comment->subcomment->getAttributes()["id"] }}' method="post" action="{{ route('edit_comment',$comment->subcomment->getAttributes()['id']) }}">
				@method('PUT')
                @csrf
				Nickname:{{ $comment->first_name }}
				  <p><img style="height:50px;width:50px;" src="/{{ $comment->avatar }}"></p>
				  <input type="hidden" name="username" value="{{ $comment->first_name }}" />
				  <br />
				  Comment:<textarea name="comment">{{ $comment->subcomment->getAttributes()["comment"] }}</textarea>
				  <br />
				  <a href=""><input type="submit" name="submit" value="Post comment" /></a>
				  <input data-value='{{ $comment->subcomment->getAttributes()["id"] }}' class="answer" type="button" name="answer" value="Answer" />
			      <input data-value='{{ $comment->subcomment->getAttributes()["id"] }}' class="cancel" type="button" name="cancel" value="Cancel" />
			</form>
			<form data-parent='{{ $comment->subcomment->getAttributes()["id"] }}' action="{{ route('add_parent_comment', ['id' => $post->product_id,'parent_id' => $comment->subcomment->getAttributes()['id']]) }}" method="post">
				@method('PUT')
                @csrf
						Nickname:{{ Auth::user()->name }}
						<br />
						Add a comment:
						<br />
						<textarea name="comment"></textarea>
						<br />
						<div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary" name="submit" value="Post comment">Submit</button>
			  <input data-value='{{ $comment->subcomment->getAttributes()["id"] }}' class="cancel_parent" type="button" name="cancel" value="Cancel" />
            </div>
		    </form>
			</td>
			<td>
			@if(Auth::user()->id)
                    <ul>
                        <li data-value='{{ $comment->subcomment->getAttributes()["id"] }}' class="edit" value='{{ $comment->subcomment->getAttributes()["id"] }}'>
                           edit
                        </li>
						<li>
                            <a href="{{ route('delete_comment',$comment->subcomment->getAttributes()['id']) }}">delete</a>
                        </li>
                    </ul>@endif
                </td>
			</tr>
				
				</tbody>
				</table>
				@php $comment->subcomment = $comment->subcomment->subcomment @endphp
				@endif	
				@endfor
				@endforeach
			   </div>
            </div>
        </div>
    </div>
</div>
@endsection