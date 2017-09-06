<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

//Вывод формы
//Route::get('/products/create/',[
//        'uses' => 'ProductController@create',
//        'as'   => 'products.create']); // Алиас URI

//Обработка формы, запись в БД
//Route::post('/products/',[
//    'uses' => 'ProductController@store',
//    'as'   => 'products.store']); // Алиас URI

Route::group(['prefix' => 'products'], function() {
    $controller = 'ProductController';
    Route::get('create', "$controller@create")->name('products.create');
    Route::get('createJson', "$controller@createJson")->name('products.createJson');
    Route::post('store', "$controller@store")->name('products.store');
    Route::get('edit/{id}', "$controller@edit")->name('products.edit');
    Route::put('update/{id}', "$controller@update")->name('products.update');
    Route::get('delete/{id}', "$controller@delete")->name('products.delete');
    Route::delete('destroy/{id}', "$controller@destroy")->name('products.destroy');
    Route::get('', "$controller@index")->name('products.index');
});

Route::group(['prefix' => 'tags'], function () {
    $controller = 'TagController';
    Route::get('create', "$controller@create")->name('tags.create');
    Route::post('store', "$controller@store")->name('tags.store');
    Route::get('edit/{id}', "$controller@edit")->name('tags.edit');
    Route::put('update/{id}', "$controller@update")->name('tags.update');
    Route::get('delete/{id}', "$controller@delete")->name('tags.delete');
    Route::delete('destroy/{id}', "$controller@destroy")->name('tags.destroy');
    Route::get('', "$controller@index")->name('tags.index');
});

Route::group(['prefix' => 'messages'], function (){
   $controller = 'MessageController';
   Route::get('create', "$controller@create")->name('messages.create');
   Route::post('store', "$controller@store")->name('messages.store');
   Route::get('edit/{id}', "$controller@edit")->name('messages.edit');
   Route::put('update/{id}', "$controller@update")->name('messages.update');
   Route::get('delete/{id}', "$controller@delete")->name('messages.delete');
   Route::delete('destroy/{id}', "$controller@destroy")->name('messages.destroy');
   Route::get('', "$controller@index")->name('messages.index');
   Route::get('{tag}', "$controller@showMessagesAsTag")->name('messages.show.asTag');
});

Route::group(['prefix' => 'images'], function () {
    $controller = 'ImageController';
    Route::get('', "$controller@index")->name('images.index');
    Route::get('{id}', "$controller@show")->name('images.show')->where('id', '\d+');
    Route::get('add', "$controller@add")->name('images.add');
    Route::post('', "$controller@create")->name('images.create');
    Route::get('{id}/remove', "$controller@remove")->name('images.remove');
    Route::delete('{id}', "$controller@destroy")->name('images.destroy')->where('id','\d+');
});

Route::group(['prefix' => 'users'], function () {
   $controller = 'UserController';
   Route::get('create', "$controller@create")->name('users.create');
   Route::post('store', "$controller@store")->name('users.store');
   Route::get('edit/{id}', "$controller@edit")->name('users.edit');
   Route::put('update/{id}', "$controller@update")->name('users.update');
   Route::get('delete/{id}', "$controller@delete")->name('users.delete');
   Route::delete('destroy/{id}', "$controller@destroy")->name('users.destroy');
   Route::get('index', "$controller@index")->name('users.index');
   Route::get('indexJson', "$controller@indexJson")->name('users.indexJson');
   Route::get('{user}', "$controller@showUser")->name('users.show.user');
   Route::get('{user}/Json', "$controller@showUserJson")->name('users.show.userJson');
   Route::get('{user}/messages/create', "$controller@addMessageToUser")->name('users.addMessageToUser');
   Route::post('{user}/messages/store', "$controller@storeMessageToUser")->name('users.storeMessageToUser');
   Route::post('{user}/messages/storeJson', "$controller@storeMesssageToUserJson")->name('users.storeMessageToUserJson');
   Route::delete('{user}/messages/delete/{id}', "$controller@deleteMessageFromUser")->name('users.deleteMessageFromUser');
   Route::delete('{user}/messages/deleteJson/{id}', "$controller@deleteMessageFromUserJson")->name('users.deleteMessageFromUserJson');
   //Route::get('{user}/images/create', "$controller@addImageToUser")->name('users.addImageToUser');
   //Route::post('{user}/images/store', "$controller@storeImageToUser")->name('users.storeImageToUser');
   Route::get('{user}/avatar/create', "$controller@addAvatarToUser")->name('users.addAvatarToUser');
   Route::get('{user}/avatar/createJson', "$controller@addAvatarToUserJson")->name('users.addAvatarToUserJson');
   Route::post('{user}/avatar/store', "$controller@storeAvatarToUser")->name('users.storeAvatarToUser');
   Route::post('{user}/avatar/storeJson', "$controller@storeAvatarToUserJson")->name('users.storeAvatarToUserJson');
   Route::post('{user}/messages/{message}/comments/store', "$controller@storeCommentToMessage")->name('users.storeCommentToMessage');
   Route::post('{user}/messages/{message}/comments/storeJson', "$controller@storeCommentToMessageJson")->name('users.storeCommentToMessageJson');
   Route::delete('{user}/messages/{message}/comments/delete', "$controller@deleteCommentFromMessage")->name('users.deleteCommentFromMessage');
   Route::delete('{user}/messages/{message}/comments/deleteJson', "$controller@deleteCommentFromMessageJson")->name('users.deleteCommentFromMessageJson');
   Route::post('{user}/avatar/{id}/destroy', "$controller@editAvatarFromUser")->name('users.editAvatarFromUser');
   Route::post('{user}/avatar/{id}/destroyJson', "$controller@editAvatarFromUserJson")->name('users.editAvatarFromUserJson');
   Route::get('{user}/messages/{id}/isLikedByMe', "$controller@isLikedByMe")->name('users.isLikedByMe');
   Route::get('{user}/messages/{id}/isLikedByMeJson', "$controller@isLikedByMeJson")->name('users.isLikedByMeJson');
   Route::post('{user}/messages/{id}/like', "$controller@like_for_message")->name('users.like.message');
   Route::post('{user}/messages/{id}/likeJson', "$controller@like_for_messageJson")->name('users.like.messageJson');
   Route::post('{user}/comments/{id}/like', "$controller@like_for_comment")->name('users.like.comment');
   Route::post('{user}/comments/{id}/likeJson', "$controller@like_for_commentJson")->name('users.like.commentJson');
   Route::get('{user}/myMessages', "$controller@myMessages")->name('users.myMessages');
   Route::get('{user}/myMessagesJson', "$controller@myMessagesJson")->name('users.myMessagesJson');
   Route::get('{user}/myMessages/{user2}', "$controller@myMessagesDialog")->name('users.myMessages.dialog');
   Route::get('{user}/myMessages/{user2}/Json', "$controller@myMessagesDialogJson")->name('users.myMessages.dialogJson');
   Route::post('{user}/myMessages/{user2}/store', "$controller@usersMyMessageDialogStore")->name('users.myMessage.dialog.store');
   Route::post('{user}/myMessages/{user2}/storeJson', "$controller@usersMyMessageDialogStoreJson")->name('users.myMessage.dialog.storeJson');
   Route::post('{user}/addToFriends', "$controller@addToFriends")->name('users.addToFriends');
   Route::post('{user}/addToFriendsJson', "$controller@addToFriendsJson")->name('users.addToFriendsJson');
   Route::delete('{user}/deleteFromFriends', "$controller@deleteFromFriends")->name('users.deleteFromFriends');
   Route::delete('{user}/deleteFromFriendsJson', "$controller@deleteFromFriendsJson")->name('users.deleteFromFriendsJson');
   Route::get('{user}/myFriends', "$controller@myFriends")->name('users.myFriends');
   Route::get('{user}/myFriendsJson', "$controller@myFriendsJson")->name('users.myFriendsJson');

});



//Route::get('/test/', ['uses' => 'ProductController@test']);

use App\User;



//Route::get('users/{user}/messages/create', "UserController@addMessageToUser1")->name('users.addMessageToUser');

Auth::routes();

Route::get('/home', 'HomeController@index');
