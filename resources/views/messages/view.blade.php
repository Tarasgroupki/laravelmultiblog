@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Product</h2>
            </div>
        </div>
    </div>


    <div align="left">
        <img style="height:200px; width:300px;" src="{{ $fromAvatar }}">
        <div><h3>{{ $from->name }}</h3>
            @foreach ($messages as $message)
               @if($message->from_id == $from->id)
                 @if($message->is_delete_from == null)
                        <div>
                            {{ $message->message }}<a href="{{ route('chat_delete',$message->id) }}">×</a>
                        </div>
                        @else
                        <div>
                            {{ "This message was deleted!" }}
                        </div>
                 @endif
               @endif
            @endforeach
    </div>
    <div align="right">
        <img style="height:200px; width:300px;" src="{{ $whomAvatar }}">
        <div><h3>{{ $whom->name }}</h3>
            @foreach ($messages as $message)
                @if($message->whom_id == $from->id)
                    @if($message->is_delete_from == null)
                        <div>
                            {{ $message->message }}<a href="{{ route('chat_delete',$message->id) }}">×</a>
                        </div>
                    @else
                        <div>
                            {{ "This message was deleted!" }}
                        </div>
                    @endif
                @endif
            @endforeach
    </div>
    </div>
    <form action="{{ route('chat.store') }}" method="POST" >
    @csrf
       <input type="hidden" name="from_id" value="{{ $from->id }}"/>
       <input type="hidden" name="whom_id" value="{{ $whom->id }}"/>
       <textarea name="message">

       </textarea>
       <button type="submit" class="btn btn-danger">Send</button>
    </form>
@endsection