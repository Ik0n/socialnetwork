@extends('layouts.base')

@section('title', trans('messages.messages.list'))

@section('content')
    <a href="{{ route('messages.create') }}">
        {{ trans('messages.messages.create') }}
    </a>

    <table class="historyTable" align="center" border="1" width="100%">
        <tr class="history-tr-table">
            <td colspan="100">{{ trans('messages.messages.content') }}</td>
        </tr>
    @foreach($messages as $m)
        <tr class="history-tr-table">
            <td> {{ $m->content }} </td>
            <td> {{ $m->user_id_recipient }} </td>
            <td> {{ $m->user_id_sender }} </td>
            @foreach($m->tags as $t)
            <td> {{ $t->title }} </td>
            @endforeach
            <td><a href="{{ route('messages.edit', [
                    'id' => $m->id]) }}">
                    {{ trans('messages.edit') }}
                </a>
            </td>
            <td><a href="{{ route('messages.delete', [
                    'id' => $m->id]) }}">
                    {{ trans('messages.delete') }}
                </a>
            </td>
        </tr>

    @endforeach
    </table>

@endsection
