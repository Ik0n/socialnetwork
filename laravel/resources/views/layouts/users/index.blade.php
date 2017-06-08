@extends('layouts.base')

@section('title', 'User list')

@section('content')
    <a href="{{ route('users.create') }}">
        Add user
    </a>

    <table class="historyTable" align="center" border="1" width="100%">
        <tr class="history-tr-table">
            <td colspan="11"> Users </td>
        </tr>
    @foreach($users as $u)

        <tr class="history-tr-table">
            <td> {{ $u->name }} </td>
            <td> {{ $u->email }} </td>
            <td> {{ $u->number }} </td>
            <td> {{ $u->first_name }} </td>
            <td> {{ $u->last_name }} </td>
            <td> {{ $u->third_name }} </td>
            <td> {{ $u->country }} </td>
            <td> {{ $u->city }} </td>
            <td>
                <a href="{{ route('users.show.user', [
                    'authUser' => $u->name]) }}">
                    перейти на страницу пользователя
                </a>
            </td>
        </tr>

    @endforeach
    </table>

@endsection
