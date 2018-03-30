<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Task;
use App\Timer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\API\ApiResponse;

class TasksController extends BaseController
{


    public function index()
    {
        $tasks = Auth::user()->tasks()->get();
        return $this->sendOkResponse($tasks->toArray(), 'Tasks retrieved successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();

        $task = Task::where('user_id', $user->id)->where('id', $id)->first();

        if (!$task) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        return $this->sendOkResponse($task->toArray(), 'Tasks retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $task = Task::where('user_id', $user->id)->where('id', $id)->first();

        if (!$task) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $task->update(
            [
                'name' => $request->name,
                'description' => $request->description
            ]
        );

        return $this->sendOkResponse($task->toArray(), 'Task updated successfully.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $task = new Task([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description
        ]);
        $task->save();

        return $this->sendOkResponse($task->toArray(), 'Task created successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $task = Task::where('user_id', $user->id)->where('id', $id)->first();

        if (!$task) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $task->delete();
        return $this->sendOkResponse($task->toArray(), 'Task successfully deleted.');
    }
}
