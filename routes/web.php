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

// Route::get('/', function () {

//     return view('welcome');


// });

// RUTAS GENERALES
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home/{categoryId?}', 'HomeController@index')->name('home');
Route::get('/index', 'HomeController@index')->name('index');

//buscador de componentes
Route::get('/article/components-search-result/{search?}', 'ComponentController@componentsSearchResult')->name('component.componentsSearchResult');

// RATING
Route::get('/ratings', 'RatingController@hello');
Route::post('/ratings', 'RatingController@store')->name('rating.store');
// USUARIO
Route::get('/configuracion', 'userController@config')->name('config');
Route::post('/user/update', 'userController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'userController@getImage')->name('user.avatar');
Route::get('/perfil/{id}', 'userController@profile')->name('profile');
Route::get('/gente/{search?}', 'userController@index')->name('user.index');
Route::get('/users', 'userController@list')->name('user.list');
Route::get('/user/block/{id}', 'UserController@block')->name('user.block');
Route::get('/user/unblock/{id}', 'UserController@unblock')->name('user.unblock');

// CATEGORY
Route::get('/categories', 'categoryController@list')->name('category.list');
Route::get('/category/edit/{id}', 'categoryController@edit')->name('category.edit');
Route::post('category/update', 'categoryController@update')->name('category.update');
Route::get('/category/delete/{id}', 'categoryController@delete')->name('category.delete');
Route::get('/create-category', 'categoryController@new')->name('category.new');
Route::post('category/save', 'categoryController@save')->name('category.save');




// COMPONENT
Route::get('/subir-componente', 'componentController@create')->name('component.create');
Route::post('/component/save', 'componentController@save')->name('component.save');
Route::get('/component/file/{filename}', 'componentController@getComponent')->name('component.file');
Route::get('/component/{id}', 'componentController@detail')->name('component.detail');
Route::get('/component/delete/{id}', 'componentController@delete')->name('component.delete');
Route::get('/component/editar/{id}', 'componentController@edit')->name('component.edit');
Route::post('/component/update', 'componentController@update')->name('component.update');

// COMMENT
Route::post('/comment/save', 'commentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'commentController@delete')->name('comment.delete');

// LIKE
Route::get('/like/{component_id}', 'likeController@like')->name('like.save');
Route::get('/dislike/{component_id}', 'likeController@dislike')->name('like.delete');
Route::get('/likes', 'likeController@index')->name('likes');

// INFORMACION IMPORTANTE
Route::get('/terminos-de-uso', 'HomeController@terminosDeUso')->name('terminosDeUso');
Route::get('/politica-de-privacidad', 'HomeController@privacyPolicy')->name('privacyPolicy');
Route::get('/política-de-cookies', 'HomeController@cookiesPolicy')->name('cookiesPolicy');



