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
Route::get('/list', 'ListController@index');
Route::post('/list', 'ListController@create');
Route::post('delete', 'ListController@delete');

Route::get('/', 'HomeController@index')->name('welcome');
Route::post('/subscribe', 'SubscriberController@subscribe')->name('add.subscriber');
Route::get('/post/all', 'PostsController@allposts')->name('allposts');

Route::get('post/{slug}', 'PostController@show')->name('post.show');
Route::get('category/{slug}', 'PostController@categoryByPost')->name('category.post');
Route::get('tags/{slug}', 'PostController@categoryBytags')->name('tags.post');
Route::get('/search', 'PostController@search')->name('post.search');

Route::get('profile/{username}', 'AuthorProfileController@index')->name('author.profile');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function ()
{
	Route::post('favorite/{id}/add', 'FavoriteController@add')->name('add.favorite');
	Route::post('comment/{post}/add', 'CommentController@add')->name('add.comment');
});

//        Admin Route Group
Route::group(['as' => 'admin.', 'namespace' => 'admin', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function(){
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::resource('tag', 'TagController');
	Route::resource('category', 'CategoryController');
	Route::resource('post', 'PostController');
	Route::get('pending/post', 'PostController@pending')->name('pending.post');
	Route::put('approve/post/{id}', 'PostController@approve')->name('approve.post');

	Route::get('subscribes', 'SubscriberController@index')->name('subscriber.index');
	Route::delete('subscriber/{id}', 'SubscriberController@delete')->name('subscriber.delete');

	Route::get('comment', 'CommentsController@index')->name('comments.index');
	Route::delete('comment/{id}', 'CommentsController@delete')->name('comment.delete');

	Route::get('/settings', 'SettingsController@index')->name('settings.index');
	Route::put('/update/profile', 'SettingsController@update')->name('update.profile');
	Route::put('/change/password', 'SettingsController@updatepassword')->name('update.password');

	Route::get('favorite/posts', 'FavoritePostController@index')->name('favorite.index');
	Route::delete('favorite/{id}/destroy', 'FavoritePostController@destroy')->name('favorite.destroy');

	Route::get('authors', 'AuthorsController@index')->name('author.index');
	Route::delete('author/{id}/destroy', 'AuthorsController@destroy')->name('author.destroy');
});
//        Author Route Group
Route::group(['as' => 'author.', 'namespace' => 'author', 'prefix' => 'author', 'middleware' => ['auth', 'author']], function(){
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::resource('post', 'PostController');

	Route::get('/settings', 'SettingsController@index')->name('settings.index');
	Route::put('/update/profile', 'SettingsController@update')->name('update.profile');
	Route::put('/change/password', 'SettingsController@updatepassword')->name('update.password');

	Route::get('comment', 'CommentController@index')->name('comments.index');
	Route::delete('comment/{id}', 'CommentController@delete')->name('comment.delete');
});

View::composer('layouts.frontend.partial.footer', function ($view)
{
	$categories = App\Category::all();
	$view->with('categories', $categories);
});


