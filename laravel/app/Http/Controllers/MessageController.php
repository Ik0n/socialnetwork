<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Message;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function create() {
        $message = new Message();
        $tags = Tag::orderBy('title')->pluck('title','id');
        $id = Auth::user()->getAuthIdentifier();

        return view('layouts.messages.create', [
            'entity' => $message,
            'tags' => $tags,
            'user' => $id,
        ]);
    }

    public function store(MessageRequest $request) {
        $id = Auth::user()->getAuthIdentifier();
        $attributes = $request->only(['content', 'tag_id']);
        $attributes['user_id_recipient'] = $id;
        $attributes['user_id_sender'] = $id;
        //var_dump($attributes);
        $message = Message::create($attributes);

        $message->tags()->sync(
            $attributes['tag_id']
        );



        return redirect(route('messages.index'));
    }

    public function edit($id_message) {
        $messages = Message::findOrFail($id_message);
        $tags = Tag::orderBy('title')->pluck('title','id');
        $id = Auth::user()->getAuthIdentifier();

        return view('layouts.messages.edit' , [
            'entity' => $messages,
            'tags' => $tags,
            'user' => $id,
        ]);
    }

    public function update(MessageRequest $request, $id_message) {
        $message = Message::findOrFail($id_message);
        $id = Auth::user()->getAuthIdentifier();

        $attributes = $request->only(['message', 'tag_id']);
        $attributes['user_id_recipient'] = $id;
        $attributes['user_id_sender'] = $id;
        $message->update($attributes);

        $message->tags()->sync(
            $attributes['tag_id']
        );

        /* return redirect(route('tags.edit', [
            'id' => $tag->id
        ])); */

        return redirect(route('messages.index'));
    }

    public function delete($id_message) {
        $messages = Message::findOrFail($id_message);
        $tags = Tag::orderBy('title')->pluck('title','id');
        $id = Auth::user()->getAuthIdentifier();

        return view('layouts.messages.delete', [
            'entity' => $messages,
            'tags' => $tags,
            'user' => $id,
        ]);

    }

    public function destroy($id) {
        $message = Message::findOrFail($id);
        $message->delete($id);

        return redirect(route('messages.index'));

    }

    public function index() {

        $id = Auth::user()->getAuthIdentifier();

        return view('layouts.messages.index', [
            'messages' => Message::where('user_id_recipient', '=', $id)->orderBy('content', 'ASC')->with(['tags'])
                ->get()
        ]);

    }
}
