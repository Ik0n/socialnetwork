<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateImageRequest;
use App\Http\Requests\MessageRequest;
use App\Message;
use App\User;
use App\Tag;
use App\Image;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->disk = 'image_disk';
    }

    public function create() {
        $user = new User();

        return view('layouts.users.create', [
           'entity' => $user
        ]);
    }

    public function store(UserRequest $request) {
        $attributes = $request->only([
            'name',
            'password',
            'email',
            'number',
            'first_name',
            'last_name',
            'third_name',
            'country',
            'city',
        ]);
        User::create($attributes);

       // return redirect(route('users.index'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('layouts.users.edit', [
            'entity' => $user
        ]);
    }

    public function update(UserRequest $request, $id) {
        $user = User::findOrFail($id);

        $attributes = $request->only([
            'name',
            'password',
            'email',
            'number',
            'first_name',
            'last_name',
            'third_name',
            'county',
            'city',
        ]);

        $user->update($attributes);

        return redirect(route('users.index', [
                'id' => $user->id
            ]));
    }

    public function delete($id) {
        $user = User::findOrFail($id);

        return view('layouts.users.delete', [
           'entity' => $user
        ]);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete($id);

        return redirect(route('users.index'));
    }

    public function index() {
        $authUser = User::findOrFail(Auth::user()->getAuthIdentifier())->name;

        return view('layouts.users.index', [
           'users' => User::orderBy('name', 'ASC')
                                    ->get(),
            'authUserName' => $authUser,
        ]);
    }

    public function showUser(User $user) {
        //$userok = User::where('name' , '=', $user)->take();
        //var_dump($user->messages()->orderBy('content')->get());
        //var_dump($user);
        //var_dump($user);
        $messages = $user->myReceivedMessages()->orderBy('created_at')->get();
        $messagesForDelete = $user->mySentMessages();
            //->paginate(5);
        $images = $user->myReceivedImages()->orderBy('created_at')->get();
        $avatar = $user->findOrFail(Auth::user()->getAuthIdentifier())->filename;
        $comments = Comment::get();
        $tags = Tag::orderBy('title')->pluck('title', 'id');
        $authUser = Auth::user()->getAuthIdentifier();
        $authUserName = User::findOrFail(Auth::user()->getAuthIdentifier())->name;

        foreach ($messages as $m) {
            $m['name'] = User::findOrFail($m->user_id_sender)->name;
        }

        foreach ($images as $i) {
            $i['name'] = User::findOrFail($i->user_id_sender)->name;
        }

        foreach ($comments as $c) {
            $c['name'] = User::findOrFail($c->user_id)->name;
        }

        return view('layouts.users.showUser', [
           'user' => $user,
            'messages' => $messages,//->paginate(1),
            'images' => $images,
            'avatar' => $avatar,
            'comments' => $comments,
            'tags' => $tags,
            'authUser' => $authUser,
            'authUserName' => $authUserName,
            'messagesForDelete' => $messagesForDelete,
            //'authUser' => $authUser,
        ]);
    }

    private function checkAuth() {
        $authUser = Auth::user()->getAuthIdentifier();

        return $authUser;
    }

    ///////////////////////////////////////////////////////////////////////
    ////
    ////  Vopros 9 i 27
    ////
    public function addMessageToUser1(User $user, Request $request)
    {
        $message = new Message();
        $tags = Tag::orderBy('title')->pluck('title', 'id');
        $id = Auth::user()->getAuthIdentifier();

        return view('layouts.users.addMessageToUser', [
            'entity' => $message,
            'tags' => $tags,
            'id' => $id,
            'user' => $user,
        ]);
    }

    public function storeMessageToUser(User $user, MessageRequest $request) {
        $id = Auth::user()->getAuthIdentifier();
        $attributes = $request->only(['content', 'tag_id']);
        $attributes['user_id_recipient'] = $user->id;
        $attributes['user_id_sender'] = $id;

        //var_dump($attributes);
        $message = Message::create($attributes);
        if ($attributes['tag_id'] != null) {
            $message->tags()->attach($this->createAndGetTags($attributes['tag_id']));
        }

        /*$message->tags()->sync(
            $attributes['tag_id']
        );*/

        return redirect(route('users.show.user', [
            'user' => $user->name,
        ]));
    }

    public function deleteMessageFromUser(User $user, $id) {
        $message = Message::findOrFail($id);
        $message->delete($id);

        return redirect(route("users.show.user", [
            'user' => $user->name,
        ]));
    }

    private function createAndGetTags($str) {
        $tags = null;
        foreach(explode(' ', $str) as $tag) {
            $tags[] = Tag::where('title', '=', $tag)->get()->count() == 0 ?
                Tag::create(['title' => $tag])->id :
                Tag::where('title', '=', $tag)->get()->first()->id;
        }
        return $tags;
    }

    public function editMessageToUser(User $user, UserRequest $request) {
        $id = Auth::user()->getAuthIdentifier();
        $attributes = $request->only(['content', 'tag_id']);
        $attributes['user_id_recipient'] = $user->id;
        $attributes['user_id_sender'] = $id;


    }

    public function addImageToUser(User $user) {

        return view('layouts.users.addImageToUser', [
            'image' => new Image(),
            'user' => $user,
            'id' => Auth::user()->getAuthIdentifier(),
        ]);
    }

    public function addAvatarToUser(User $user) {
        $authUserName = Auth::user()->getAuthIdentifier();


        return view('layouts.users.addAvatarToUser', [
            'user' => $user,
            'id' => Auth::user()->getAuthIdentifier(),
            'authUserName' => $authUserName,
        ]);
    }

    public function storeImageToUser(User $user, CreateImageRequest $request) {
        $file = $request->file('file');
        $filename = $this->fixedStore($file, '', $this->disk);

        try {
            $image = Image::create([
                'filename' => $filename,
                'user_id_recipient' => $user->id,
                'user_id_sender' => Auth::user()->getAuthIdentifier(),
            ]);
        }
        catch (\Exception $exception) {
            Storage::disk($this->disk)->delete($filename);
            throw $exception;
        }
    }

    public function storeAvatarToUser(User $user, CreateImageRequest $request) {
        $file = $request->file('file');
        $filename = $this->fixedStore($file, '', $this->disk);
        $authUserName = Auth::user()->getAuthIdentifier();

        try {
            $attributes = $request->only(['filename']);
            $attributes['filename'] = $filename;
            $user->update($attributes);
        }
        catch (\Exception $exception) {
            Storage::disk($this->disk)->delete($filename);
            throw $exception;
        }

        return redirect(route('users.show.user', [
            'user' => $user->name,
            'authUserName' => $authUserName,
        ]));
    }

    private function fixedStore($file, $path, $disk) {
        $folder = Storage::disk($disk)->getAdapter()->getPathPrefix();
        $temp = tempnam($folder, '');
        $filename = pathinfo($temp, PATHINFO_FILENAME);
        $extension = $file->extension();

        try {
            $basename = $file->storeAs($path, "$filename.$extension", $disk);
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            unlink($temp);
        }
        return $basename;
    }

    public function storeCommentToMessage(User $user, Message $message, Request $request) {
        $id = Auth::user()->getAuthIdentifier();
        $attributes = $request->only(['content']);
        $attributes['message_id'] = $message->id;
        $attributes['user_id'] = $id;

        //var_dump($attributes);
        $comment = Comment::create($attributes);

        return redirect(route('users.show.user', [
            'user' => $user->name,
        ]));
    }



}
