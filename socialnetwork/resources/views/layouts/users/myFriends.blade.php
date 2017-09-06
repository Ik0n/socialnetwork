@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>

@section('content')
    <table class="table">
        @foreach($authUser->friends as $friend)
            <tr>
                @if($friend->filename == "qqq")
                    <td><img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-responsive img-rounded img-thumbnail"></td>
                @endif
                @if($friend->filename != "qqq")
                    <td><img src="{{ asset('storage/images/' . $friend->filename) }}" alt="" class="img-responsive img-rounded img-thumbnail"></td>
                @endif
                {{ Form::model($user , [
                    'method' => 'GET',
                    'route' => [
                        'users.myMessages.dialog',
                         $user->name,
                         $friend->name
                        ]]) }}
                <td>{{ Form::submit($friend->name, ['class' => 'btn btn-primary']) }}</td>
                {{ Form::close() }}
            </tr>
        @endforeach
    </table>




@endsection

@endsection