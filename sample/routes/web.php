<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();


Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');

    
    Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index'); 
   

    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    //フォルダ削除
    Route::get('/folders/{id}/delete', 'TaskController@index');
    Route::post('/folders/{id}/delete', 'FolderController@delete')->name('folders.delete');

    //フォルダ編集
    Route::get('/folders/{id}/edit', 'FolderController@showEditForm')->name('folders.edit');
    Route::post('/folders/{id}/edit', 'FolderController@edit');


    Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
    Route::post('/folders/{id}/tasks/create', 'TaskController@create');

    Route::get('/folders/{id}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
    Route::post('/folders/{id}/tasks/{task_id}/edit', 'TaskController@edit');

    //タスク削除, getの場合はtask一覧画面へ戻す
    Route::get('/folders/{id}/tasks/{task_id}/delete', 'TaskController@index');
    Route::post('/folders/{id}/tasks/{task_id}/delete', 'TaskController@delete')->name('tasks.delete');

    //カレンダー表示test
    Route::get('/calendars/calendar', 'CalendarController@index')->name('calendars.index');


});
