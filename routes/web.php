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
/*
 * My Method To Make Group Of Route.
 */
/*Route::group(['namespace'=>'BackEnd','prefix'=>'admin','middleware'=>'admin'],function (){


    Route::get('home','Home@index')->name('admin.home');
    Route::resource('users','Users')->except(['show']);
    Route::resource('categories','Categories')->except(['show']);
    Route::resource('skills','Skills')->except(['show']);
    Route::resource('tags','Tags')->except(['show']);
    Route::resource('pages','Pages')->except(['show']);
    Route::resource('videos','Videos')->except(['show']);
    Route::resource('messages','Messages')->only(['index','destroy','edit']);
    Route::post('comments','Videos@commentStore')->name('comment.store');
    Route::get('comments/{id}','Videos@commentDelete')->name('comment.delete');
    Route::post('comments/{id}','Videos@commentUpdate')->name('comment.update');
    Route::post('messages/replay/{id}','Messages@replay')->name('message.replay');

});*/


Route::namespace('BackEnd')->prefix('admin')->middleware('admin')->group(function(){

    Route::get('home','Home@index')->name('admin.home');
    Route::resource('users','Users')->except(['show']);
    Route::resource('categories','Categories')->except(['show']);
    Route::resource('skills','Skills')->except(['show']);
    Route::resource('tags','Tags')->except(['show']);
    Route::resource('pages','Pages')->except(['show']);
    Route::resource('videos','Videos')->except(['show']);
    Route::resource('messages','Messages')->only(['index','destroy','edit']);
    Route::post('comments','Videos@commentStore')->name('comment.store');
    Route::get('comments/{id}','Videos@commentDelete')->name('comment.delete');
    Route::post('comments/{id}','Videos@commentUpdate')->name('comment.update');
    Route::post('messages/replay/{id}','Messages@replay')->name('message.replay');


});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('category/{id}', 'HomeController@category')->name('front.category');
Route::get('skill/{id}', 'HomeController@skills')->name('front.skill');
Route::get('video/{id}', 'HomeController@video')->name('frontend.video');
Route::get('tag/{id}', 'HomeController@tags')->name('front.tags');
Route::post('contact-us', 'HomeController@messageStore')->name('contact.store');
Route::get('/','HomeController@welcome')->name('frontend.landing');
Route::get('page/{id}/{slug?}', 'HomeController@page')->name('front.page');
Route::get('profile/{id}/{slug?}', 'HomeController@profile')->name('front.profile');

/*
 *My Method To Make Middleware Group
 */
/*Route::group(['middleware'=>'auth'],function (){
    Route::post('comments/{id}', 'HomeController@commentUpdate')->name('front.commentUpdate');
    Route::post('comments/{id}/create', 'HomeController@commentStore')->name('front.commentStore');
    Route::post('profile', 'HomeController@profileUpdate')->name('profile.update');
});*/

Route::middleware('auth')->group(function(){

Route::post('comments/{id}', 'HomeController@commentUpdate')->name('front.commentUpdate');
Route::post('comments/{id}/create', 'HomeController@commentStore')->name('front.commentStore');
Route::post('profile', 'HomeController@profileUpdate')->name('profile.update');


});



