@extends('layouts.admin')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($users as $user)
                    {{ $user->name }}
                    {{ $user->email }}
                    <ul>
                        <li>
                            <a href="{{ route('chat_view',$user->id) }}">Check User</a>
                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>

@endsection