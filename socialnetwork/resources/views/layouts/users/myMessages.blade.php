<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>

@extends('layouts.base')

@section('title')
    <title>{{ $user->name }}</title>

    @section('content')
        <table class="table">
        @foreach($users as $u)
            <tr>
            @if($u->filename == "qqq")
                <td><img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-responsive img-rounded img-thumbnail"></td>
            @endif
            @if($u->filename != "qqq")
                <td><img src="{{ asset('storage/images/' . $u->filename) }}" alt="" class="img-responsive img-rounded img-thumbnail"></td>
            @endif
            {{ Form::model($user , [
                'method' => 'GET',
                'route' => [
                    'users.myMessages.dialog',
                     $user->name,
                     $u->name
                    ]]) }}
            <td>{{ Form::submit($u->name, ['class' => 'btn btn-primary']) }}</td>
            {{ Form::close() }}
            </tr>
        @endforeach
        </table>




    @endsection