<?php
/**
 * Created by PhpStorm.
 * User: Ik0nC
 * Date: 06.09.2017
 * Time: 20:29
 */

namespace App\Services;

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


class UserService implements \App\Contracts\UserService
{
    public function __construct()
    {
        $this->disk = 'image_disk';
    }

    public function index(Request $request) {
        if (Auth::user() == null) {
            return redirect(route('login'));
        }

        $authUserName = User::findOrFail(Auth::user()->getAuthIdentifier())->name;
        $authUser = User::findOrFail(Auth::user()->getAuthIdentifier());
        $odmen = User::findOrFail(Auth::user()->getAuthIdentifier())->admin;
        $searchString = $request->only('search');
        $searchUsers = User::where('name', 'LIKE', "%" . $searchString['search'] . "%")->get();
        $users = User::orderBy('name', 'ASC')->get();


        return [
            'authUserName' => $authUserName,
            'authUser' => $authUser,
            'odmen' => $odmen,
            'searchUsers' => $searchUsers,
            'users' => $users
        ];
    }

    public function showUser(User $user) {
        if (Auth::user() == null) {
            return redirect(route('login'));
        }

        //$userok = User::where('name' , '=', $user)->take();
        //var_dump($user->messages()->orderBy('content')->get());
        //var_dump($user);
        //var_dump($user);
        $messages = $user->myReceivedMessages()->where('private','=','0')->orderBy('created_at', 'DESC')->paginate(5);
        $messagesForDelete = $user->mySentMessages();
        //->paginate(5);
        $images = $user->myReceivedImages()->orderBy('created_at')->get();
        $avatar = $user->findOrFail(Auth::user()->getAuthIdentifier())->filename;

        $comments = Comment::get();
        $tags = Tag::orderBy('title')->pluck('title', 'id');
        $authUser = Auth::user()->getAuthIdentifier();
        $authUserName = User::findOrFail(Auth::user()->getAuthIdentifier())->name;
        $odmen = User::findOrFail(Auth::user()->getAuthIdentifier())->admin;
        $likes_for_messages = Likes_for_message::get();
        $likes_for_comments = Likes_for_comments::get();

        $userAuth = User::findOrFail(Auth::user()->getAuthIdentifier());


        //var_dump(User::findOrFail(Auth::user()->getAuthIdentifier())->friends());


        foreach ($messages as $m) {
            $m['name'] = User::findOrFail($m->user_id_sender)->name;
            $m['filenameAvatarUser'] = User::findOrFail($m->user_id_sender)->filename;
            $m['admin'] = User::findOrFail($m->user_id_sender)->admin;
            $m['likes'] = 0;
            foreach ($likes_for_messages as $like) {
                if ($m->id == $like->message_id){
                    $m['likes'] += 1;
                    if ($like->user_id == $authUser)
                        $m['likeItAuth'] = $authUser;
                }
            }
        }

        foreach ($images as $i) {
            $i['name'] = User::findOrFail($i->user_id_sender)->name;
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


        return [
            'user' => $user,
            'messages' => $messages,
            'images' => $images,
            'avatar' => $avatar,
            'comments' => $comments,
            'tags' => $tags,
            'authUser' => $authUser,
            'authUserName' => $authUserName,
            'userAuth' => $userAuth,
            'messagesForDelete' => $messagesForDelete,
            'whoLikeThatMessage' => $likes_for_messages,
            'whoLikeThatComment' => $likes_for_comments,
            'odmen' => $odmen,
        ];
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


    public function storeMessageToUser(User $user, MessageRequest $request, CreateImageRequest $imgrequest) {
        $id = Auth::user()->getAuthIdentifier();
        $attributes = $request->only(['content', 'tag_id', 'filename', 'private']);
        $attributes['user_id_recipient'] = $user->id;
        $attributes['user_id_sender'] = $id;
        $attributes['filename'] = $imgrequest->file;
        $attributes['private'] = 0;

        if($attributes['filename'] == null) {
            $attributes['filename'] = "not";
            $message = Message::create($attributes);
            if ($attributes['tag_id'] != null) {
                $message->tags()->attach($this->createAndGetTags($attributes['tag_id']));
            }
        }
        else {
            $file = $imgrequest->file('file');
            $filename = $this->fixedStore($file, '', $this->disk);

            try {
                $attributes['filename'] = $filename;
                $message = Message::create($attributes);
                if ($attributes['tag_id'] != null) {
                    $message->tags()->attach($this->createAndGetTags($attributes['tag_id']));
                }
            }
            catch (\Exception $exception) {
                Storage::disk($this->disk)->delete($filename);
                throw $exception;
            }
        }

        return $message;
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

    public function deleteMessageFromUser(User $user, $id) {
        $message = Message::findOrFail($id);
        $message->delete($id);
    }

    public function addAvatarToUser(User $user) {
        $authUserName = User::findOrFail(Auth::user()->getAuthIdentifier())->name;
        $authUserId = Auth::user()->getAuthIdentifier();
        return [
            'user' => $user,
            'authUserName' => $authUserName,
            'authUserId' => $authUserId,
            ];
    }

    public function storeAvatarToUser(User $user, CreateImageRequest $request) {
        $file = $request->file('file');
        $filename = $this->fixedStore($file, '', $this->disk);
        $authUserName = Auth::user()->getAuthIdentifier();

        try {
            $attributes = $request->only(['filename']);
            $attributes['filename'] = $filename;
            $user->update($attributes);
        } catch (\Exception $exception) {
            Storage::disk($this->disk)->delete($filename);
            throw $exception;
        }

        return [
            'user' => $user,
            'authUserName' => $authUserName
        ];
    }

    public function editAvatarFromUser(User $user) {
        Storage::disk($this->disk)->delete($user->filename);
        $user->update(['filename' => "qqq"]);

        return [
            'user' => $user
        ];
    }

    public function storeCommentToMessage(User $user, Message $message, Request $request) {
        $attributes = $request->only(['content']);
        $attributes['message_id'] = $message->id;
        $attributes['user_id'] = Auth::user()->getAuthIdentifier();;
        Comment::create($attributes);
        return [
            'user' => $user
        ];
    }

    public function deleteCommentFromMessage(User $user, $id) {
        $comment = Comment::findOrFail($id);
        $comment->delete($id);
        return [
            'user' => $user
        ];
    }

    public function isLikedByMe_for_message($id) {
        $message = Message::findOrFail($id)->first();
        if(Likes_for_message::where("user_id","=", Auth::id())->where("message_id","=",$message->id)->exists()) {
            return 'true';
        }
        return 'false';
    }

    public function like_for_message(User $user, $id) {
        $existingLike = Likes_for_message::where("message_id","=", $id)->where("user_id","=", Auth::user()->getAuthIdentifier())->first();
        if($existingLike == null) {
            Likes_for_message::create([
                'message_id' => $id,
                'user_id' => Auth::user()->getAuthIdentifier(),
            ]);
        } else {
            if ($existingLike != null) {
                $existingLike->delete();
            } else {
                //$existingLike->restore();
            }
        }
        return [
            'authUserName' => User::findOrFail(Auth::user()->getAuthIdentifier())->name
        ];
    }

    public function isLikedByMe_for_comment($id) {
        $comment = Comment::findOrFail($id)->first();
        if(Likes_for_comments::where("user_id","=", Auth::id())->where("message_id","=",$comment->id)->exists()) {
            return 'true';
        }
        return 'false';
    }

    public function like_for_comment(User $user, $id) {
        $existingLike = Likes_for_comments::where("comment_id","=", $id)->where("user_id","=", Auth::user()->getAuthIdentifier())->first();
        if($existingLike == null) {
            Likes_for_comments::create([
                'comment_id' => $id,
                'user_id' => Auth::user()->getAuthIdentifier(),
            ]);
        } else {
            if ($existingLike != null) {
                $existingLike->delete();
            } else {
                //$existingLike->restore();
            }
        }
        return [
            'authUserName' => User::findOrFail(Auth::user()->getAuthIdentifier())->name
        ];
    }

    public function myMessages(User $user) {
        $messages = Message::where("private", "!=", "0")->orderBy('created_at','DESK')->get();
        return [
            'user' => $user,
            'authUserName' => User::findOrFail(Auth::user()->getAuthIdentifier())->name,
            'users' => User::orderBy('name', 'ASC')->get(),
            'messages' => $messages
        ];
    }

    public function myMessageDialog(User $user, $user2) {
        $myRecievedMessages = Message::where("user_id_recipient","=", Auth::user()->getAuthIdentifier())->where("private","!=","0")->get();
        $mySendMessages = Message::where("user_id_sender","=", Auth::user()->getAuthIdentifier())->where("private","!=","0")->get();
        $messages = Message::where("private", "!=", "0")->orderBy('created_at','DESK')->get();
        $us = User::where("name","=",$user2)->get();
        foreach ($messages as $message) {
            $message['user_name_sender'] = User::findOrFail($message->user_id_sender)->name;
            $message['user_name_recipient'] = User::findOrFail($message->user_id_recipient)->name;
        }

        return [
            'user' => $user,
            'user2' => User::findOrFail(User::where("name","=",$user2)->get()),
            'authUserName' => User::findOrFail(Auth::user()->getAuthIdentifier())->name,
            'users' => User::orderBy('name', 'ASC')->get(),
            'myRecievedMessages' => $myRecievedMessages,
            'mySendMessages' => $mySendMessages,
            'messages' => $messages
        ];
    }

    public function usersMyMessageDialogStore(User $user, $user2, MessageRequest $request) {
        $attributes = $request->only(['content']);
        $attributes['user_id_recipient'] = User::findOrFail(User::where("name","=",$user2)->get())->id;
        $attributes['user_id_sender'] = Auth::user()->getAuthIdentifier();
        $attributes['tag_id'] = '';
        $attributes['filename'] = 'not';
        $attributes['private'] = 1;
        Message::create($attributes);
        return [
            'user' => $user->name,
            'user2' => User::findOrFail(User::where("name","=",$user2)->get())->name,
        ];
    }

    public function addToFriends(User $user, Request $request) {
        $authUser = User::findOrFail(Auth::user()->getAuthIdentifier());
        $attributes['user_id1'] = Auth::user()->getAuthIdentifier();
        $attributes['user_id2'] = $user->id;
        Friend::create($attributes);
        return [
            'user' => $user->name,
        ];
    }

    public function deleteFromFriends(User $user) {
        $friend = Friend::where(['user_id1' => Auth::user()->getAuthIdentifier(), 'user_id2' => $user->id]);
        $friend->delete(['user_id1' => Auth::user()->getAuthIdentifier(), 'user_id2' => $user->id]);
        return [
            'user' => $user->name,
        ];
    }

    public function myFriends(User $user) {
        return [
          'user' => $user,
          'authUser' => User::findOrFail(Auth::user()->getAuthIdentifier()),
          'authUserName' => User::findOrFail(Auth::user()->getAuthIdentifier())->name,
          'users' => User::orderBy('name', 'ASC')->get(),
        ];
    }

}
