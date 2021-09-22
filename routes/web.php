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

Route::get('/', function() {
    $tasks = \App\Models\Task::all();
    $projects = \App\Models\Project::all();
    return view('welcome')
            ->with('projects', $projects)
            ->with('tasks', $tasks);
});

Route::group(['prefix' => 'task', 'as' => 'task.'], function() {
    Route::get('/', 'TaskController@index')->name('index');  // List of tasks
    Route::post('/', 'TaskController@store')->name('store'); // Save a new task
    Route::post('/update', 'TaskController@update')->name('update'); // Edit task
    Route::delete('{id}', 'TaskController@drop')->name('drop'); // Delete task
    Route::post('/reorder', 'TaskController@reorder')->name('reorder'); // Reorder tasks
});

Route::group(['prefix' => 'project', 'as' => 'project.'], function() {
    Route::get('/', 'ProjectController@index')->name('index');  // List of tasks
    Route::post('/', 'ProjectController@store')->name('store'); // Create new project
});