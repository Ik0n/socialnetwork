@extends('layouts.base')

@section('title', trans('messages.tag.index'))

@section('content')
    <a href="{{ route('tags.create') }}">
        {{ trans('messages.tag.create') }}
    </a>

    <table class="historyTable" align="center" border="1" width="100%">
        <tr class="history-tr-table">
            <td colspan="3">{{ trans('messages.tag.title') }}</td>
        </tr>
    @foreach($tags as $t)

        <tr class="history-tr-table">
            <td> {{ $t->title }} </td>
            <td><a href="{{ route('tags.edit', [
                    'id' => $t->id]) }}">
                    {{ trans('messages.edit') }}
                </a>
            </td>
            <td><a href="{{ route('tags.delete', [
                    'id' => $t->id]) }}">
                    {{ trans('messages.delete') }}
                </a>
            </td>
        </tr>

    @endforeach
    </table>

@endsection
