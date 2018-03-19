<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => '/todolists/v1', 'namespace' => 'Api\TodoTasks\V1', 'as' => 'todolists.api.'], function () {
    Route::resource('tasks', 'TasksController', ['except' => ['create', 'edit']]);
    Route::resource('timers', 'TimerController', ['except' => ['create', 'edit']]);
    Route::post('tasks/{taskId}/timers/{id}/start', 'TimerController@startTimer');
    Route::post('tasks/{taskId}/start', 'TimerController@startTimerByTaskId');
    Route::post('timers/{id}/stop', 'TimerController@stopTimer');
    Route::get('runningtasktimer', 'TimerController@getRunningTimer');
});

