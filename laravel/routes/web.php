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
    return view('welcome');
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
   Route::get('', "$controller@index")->name('users.index');
   Route::get('{user}', "$controller@showUser")->name('users.show.user');
   Route::get('{user}/messages/create', "$controller@addMessageToUser1")->name('users.addMessageToUser');
   Route::post('{user}/messages/store', "$controller@storeMessageToUser")->name('users.storeMessageToUser');
   Route::delete('{user}/messages/delete/{id}', "$controller@deleteMessageFromUser")->name('users.deleteMessageFromUser');
   Route::get('{user}/images/create', "$controller@addImageToUser")->name('users.addImageToUser');
   Route::post('{user}/images/store', "$controller@storeImageToUser")->name('users.storeImageToUser');
   Route::get('{user}/avatar/create', "$controller@addAvatarToUser")->name('users.addAvatarToUser');
   Route::post('{user}/avatar/store', "$controller@storeAvatarToUser")->name('users.storeAvatarToUser');
   Route::post('{user}/messages/{message}/comments/store', "$controller@storeCommentToMessage")->name('users.storeCommentToMessage');
   Route::delete('{user}/messages/{message}/comments/delete', "$controller@deleteCommentFromMessage")->name('users.deleteCommentFromMessage');
   Route::post('{user}/avatar/{id}/destroy', "$controller@editAvatarFromUser")->name('users.editAvatarFromUser');
   Route::get('{user}/messages/{id}/isLikedByMe', "$controller@isLikedByMe")->name('users.isLikedByMe');
   Route::post('{user}/messages/{id}/like', "$controller@like")->name('users.like');
});



//Route::get('/test/', ['uses' => 'ProductController@test']);

use App\User;



//Route::get('users/{user}/messages/create', "UserController@addMessageToUser1")->name('users.addMessageToUser');

Auth::routes();

Route::get('/home', 'HomeController@index');
