<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Friend;
use App\Http\Requests\CreateImageRequest;
use App\Http\Requests\MessageRequest;
use App\Likes_for_comments;
use App\Likes_for_message;
use App\Message;
use App\User;
use App\Tag;
use App\Image;
use App\Like;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Contracts\UserService;

class UserController extends Controller
{

    public function __construct(UserService $service)
    {
        $this->disk = 'image_disk';
        $this->service = $service;
    }

    public function create() {
        if (Auth::user() == null) {
            return redirect(route('login'));
        }
        $user = new User();
        $authUserName = User::findOrFail(Auth::user()->getAuthIdentifier())->name;

        return view('layouts.users.create', [
           'entity' => $user,
            'authUserName' => $authUserName
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
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['admin'] = 1;
        $attributes['filename'] = 'qqq';
        User::create($attributes);

       return redirect(route('users.index'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $authUserName = User::findOrFail(Auth::user()->getAuthIdentifier())->name;
        if(Auth::user()->getAuthIdentifier() == $id) {
        return view('layouts.users.edit', [
            'user' => $user,
            'authUserName' => $authUserName,
        ]);
        }
        else {
            return redirect(route('users.show.user', [
                'user' => $authUserName,
                //'authUserName' => $authUserName
                ]));
        }

    }

    public function update(UserRequest $request, $id) {
        $user = User::findOrFail($id);
        $authUser = User::findOrFail(Auth::user()->getAuthIdentifier());

        $attributes = $request->only([
            'email',
            'number',
            'first_name',
            'last_name',
            'third_name',
            'country',
            'city',
        ]);

        $attributes['name'] = $authUser->name;
        $attributes['password'] = $authUser->password;



        $user->update($attributes);

        return redirect(route('users.show.user', [
                'user' => $user->name

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

    public function index(Request $request) {
        return view('layouts.users.index', [
            'users' => $this->service->index($request)['users'],
            'authUserName' => $this->service->index($request)['authUserName'],
            'authUser' => $this->service->index($request)['authUser'],
            'searchUsers' => $this->service->index($request)['searchUsers'],
            'odmen' => $this->service->index($request)['odmen'],
            'userAuth' => $this->service->index($request)['userAuth'],
        ]);
    }

    public function indexJson(Request $request) {
        $list = $this->service->index($request);
        return response()->json($list);
    }


    public function showUser(User $user) {
        return view('layouts.users.showUser', [
           'user' => $this->service->showUser($user)['user'],
            'messages' => $this->service->showUser($user)['messages'],
            'images' => $this->service->showUser($user)['images'],
            'avatar' => $this->service->showUser($user)['avatar'],
            'comments' => $this->service->showUser($user)['comments'],
            'tags' => $this->service->showUser($user)['tags'],
            'authUser' => $this->service->showUser($user)['authUser'],
            'authUserName' => $this->service->showUser($user)['authUserName'],
            'userAuth' => $this->service->showUser($user)['userAuth'],
            'messagesForDelete' => $this->service->showUser($user)['messagesForDelete'],
            'whoLikeThatMessage' => $this->service->showUser($user)['whoLikeThatMessage'],
            'whoLikeThatComment' => $this->service->showUser($user)['whoLikeThatComment'],
            'odmen' => $this->service->showUser($user)['odmen'],
        ]);
    }

    public function showUserJson(User $user) {
        $list = $this->service->showUser($user);
        return response()->json($list);
    }

    public function addMessageToUser(User $user, Request $request)
    {
        $tags = Tag::orderBy('title')->pluck('title', 'id');
        $id = Auth::user()->getAuthIdentifier();
        return view('layouts.users.addMessageToUser', [
            'tags' => $tags,
            'id' => $id,
            'user' => $user,
        ]);
    }

    public function storeMessageToUser(User $user, MessageRequest $request, CreateImageRequest $imgrequest) {
        return redirect(route('users.show.user', [
            'user' => $this->service->storeMessageToUser($user,$request,$imgrequest)['user'],
        ]));
    }

    public function storeMessageToUserJson(User $user, MessageRequest $request, CreateImageRequest $imgrequest) {;
        return response()->json($this->service->storeMessageToUser($user,$request,$imgrequest));
    }


    public function deleteMessageFromUser(User $user, $id) {
        $this->service->deleteMessageFromUser($user,$id);
        return redirect(route("users.show.user", [
            'user' => $user->name,
        ]));
    }

    public function deleteFromMessageFromUserJson(User $user, $id) {
        return response()->json($this->service->deleteMessageFromUser($user,$id));
    }

    /*
    public function editMessageToUser(User $user, UserRequest $request) {
        $id = Auth::user()->getAuthIdentifier();
        $attributes = $request->only(['content', 'tag_id']);
        $attributes['user_id_recipient'] = $user->id;
        $attributes['user_id_sender'] = $id;
    }
    */

    /* Не используется в данный момент 06.09.2017
    public function addImageToUser(User $user) {
        return view('layouts.users.addImageToUser', [
            'image' => $this->service->addImageToUser($user)['image'],
            'user' => $this->service->addImageToUser($user)['user'],
            'id' => $this->service->addImageToUser($user)['authUserId'],
        ]);
    }

    public function addImageToUserJson(User $user) {
        return response()->json($this->service->addImageToUser($user));
    }
    */


    public function addAvatarToUser(User $user) {
        return view('layouts.users.addAvatarToUser', [
            'user' => $this->service->addAvatarToUser($user)['user'],
            'id' => $this->service->addAvatarToUser($user)['authUserId'],
            'authUserName' => $this->service->addAvatarToUser($user)['authUserName'],
        ]);
    }

    public function addAvatarToUserJson(User $user) {
        return response()->json($this->service->addAvatarToUser($user));
    }

    /* Не используется в данный момент 06.09.2017
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
    */

    public function storeAvatarToUser(User $user, CreateImageRequest $request) {
        return redirect(route('users.show.user', [
            'user' => $this->service->storeAvatarToUser($user,$request)['user'],
            'authUserName' => $this->service->storeAvatarToUser($user,$request)['authUserName'],
        ]));
    }

    public function storeAvatarToUserJson(User $user, CreateImageRequest $request) {
        return response()->json($this->service->storeAvatarToUser($user,$request));
    }

    public function editAvatarFromUser(User $user) {
        return redirect(route('users.show.user', [
            'user' => $this->service->editAvatarFromUser($user)['user'],
        ]));
    }

    public function editAvatarFromUserJson(User $user) {
        return response()->json($this->service->editAvatarFromUser($user));
    }

    public function storeCommentToMessage(User $user, Message $message, Request $request) {
        return redirect(route('users.show.user', [
            'user' => $this->service->storeCommentToMessage($user,$message,$request)['user'],
        ]));
    }

    public function storeCommentToMessageJson(User $user, Message $message, Request $request) {
        return response()->json($this->service->storeCommentToMessage($user,$message,$request));
    }


    public function deleteCommentFromMessage(User $user, $id) {
        return redirect(route("users.show.user", [
            'user' => $this->service->deleteCommentFromMessage($user,$id)['user'],
        ]));
    }

    public function deleteCommentFromMessageJson(User $user, $id) {
        return response()->json($this->service->deleteCommentFromMessage($user,$id));
    }

    public function like_for_message(User $user, $id) {
        return redirect(route('users.show.user', [
            'user' => $this->service->like_for_message($user,$id)['authUserName']
        ]));
    }

    public function like_for_messageJson(User $user, $id) {
        return response()->json($this->service->like_for_message($user,$id));
    }

    public function like_for_comment(User $user, $id) {
        return redirect(route('users.show.user', [
            'user' => $this->service->like_for_comment($user,$id)['authUserName']
        ]));
    }

    public function like_for_commentJson(User $user, $id) {
        return response()->json($this->service->like_for_comment($user,$id));
    }

    public function myMessages(User $user) {
        return view('layouts.users.myMessages', [
            'user' => $this->service->myMessages($user)['user'],
            'authUserName' => $this->service->MyMessage($user)['authUserName'],
            'users' => $this->service->MyMessage($user)['users'],
            'messages' => $this->service->MyMessages($user)['messages']
        ]);
    }

    public function myMessagesJson(User $user) {
        return response()->json($this->service->myMessages($user));
    }

    public function myMessagesDialog(User $user, $user2) {
        return view('layouts.users.myMessagesDialog', [
            'user' => $this->service->myMessagesDialog($user,$user2)['user'],
            'user2' => $this->service->myMessagesDialog($user,$user2)['user2'],
            'authUserName' => $this->service->myMessagesDialog($user,$user2)['authUserName'],
            'users' => $this->service->myMessagesDialog($user,$user2)['users'],
            'myRecievedMessages' => $this->service->myMessagesDialog($user,$user2)['myRecievedMessages'],
            'mySendMessages' => $this->service->myMessagesDialog($user,$user2)['mySendMessages'],
            'messages' => $this->service->myMessagesDialog($user,$user2)['messages'],
        ]);
    }

    public function myMessagesDialogJson(User $user, $user2) {
        return response()->json($this->service->myMessagesDialog($user,$user2));
    }

    public function usersMyMessageDialogStore(User $user, $user2, MessageRequest $request) {
        return redirect(route('users.myMessages.dialog', [
            'user' => $this->service->usersMyMessageDialogStore($user,$user2,$request)['user'],
            'user2' => $this->service->usersMyMessageDialogStore($user,$user2,$request)['user2']
        ]));
    }

    public function usersMyMessageDialogStoreJson(User $user, $user2, MessageRequest $request) {
        return response()->json($this->service->usersMyMessageDialogStore($user,$user2,$request));
    }

    public function addToFriends(User $user, Request $request) {
        return redirect(route('users.show.user', [
            'user' => $this->service->addToFriends($user,$request)['user'],
        ]));
    }

    public function addToFriendsJson(User $user, Request $request) {
        return response()->json($this->service->addToFriends($user,$request));
    }

    public function deleteFromFriendsOnUserPage(User $user) {
        return redirect(route("users.show.user", [
            'user' => $this->service->deleteFromFriends($user)['user'],
        ]));
    }

    public function deleteFromFriends(User $user) {
        return redirect(route("users.myFriends", [
            'user' => $this->service->deleteFromFriends($user)['authUser'],
        ]));
    }


    public function deleteFromFriendsJson(User $user) {
        return response()->json($this->service->deleteFromFriends($user));
    }

    public function myFriends(User $user) {
        return view('layouts.users.myFriends', [
            'user' => $this->service->myFriends($user)['user'],
            'authUser' => $this->service->myFriends($user)['authUser'],
            'authUserName' => $this->service->myFriends($user)['authUserName'],
            'users' => $this->service->myFriends($user)['users'],
        ]);
    }

    public function myFriendsJson(User $user) {
        return response()->json($this->service->myFriends($user));
    }

}
