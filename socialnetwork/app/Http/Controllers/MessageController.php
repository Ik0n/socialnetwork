<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\MessageRequest;
use App\Likes_for_comments;
use App\Likes_for_message;
use App\Message;
use App\messages_tag;
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

    public function showMessagesAsTag($tag) {
        if (Auth::user() == null) {
            return redirect(route('login'));
        }

        $ta = Tag::findOrFail(Tag::where('title','=', $tag)->get())->id;
        //$tagg = messages_tag::where('tag_id','=', $ta)->get();
        //$messages = Message::where('id','=',$tagg->message_id)->get();

        $messages = Message::get();
        $likes_for_messages = Likes_for_message::get();
        $likes_for_comments = Likes_for_comments::get();
        $authUser = Auth::user()->getAuthIdentifier();
        $comments = Comment::get();

        foreach ($messages as $message) {

            $message['likes'] = 0;
            foreach ($likes_for_messages as $like) {
                if ($message->id == $like->message_id){
                    $message['likes'] += 1;
                    if ($like->user_id == $authUser)
                        $message['likeItAuth'] = $authUser;
                }
            }

        }

        foreach ($comments as $c) {
            $c['name'] = User::findOrFail($c->user_id)->name;
            $c['filenameAvatarUser'] = User::findOrFail($c->user_id)->filename;
            $c['admin'] = User::findOrFail($c->user_id)->admin;
            $c['likes'] = 0;
            foreach ($likes_for_comments as $like) {
                if ($c->id == $like->comment_id){
                    $c['likes'] += 1;
                    if ($like->user_id == $authUser)
                        $c['likeItAuth'] = $authUser;
                }
            }
        }




        return view('layouts.messages.showMessagesAsTag', [
            'tag' => Tag::findOrFail(Tag::where('title','=', $tag)->get()),
            'user' => User::findOrFail(Auth::user()->getAuthIdentifier()),
            'users' => User::get(),
            'messages' => $messages,
            'authUser' => $authUser,
            'comments' => $comments,
            'odmen' => User::findOrFail(Auth::user()->getAuthIdentifier())->admin,
            'authUserName' => User::findOrFail(Auth::user()->getAuthIdentifier())->name,

            ]);
    }
}
