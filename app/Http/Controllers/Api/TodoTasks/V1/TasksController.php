<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Task;
use App\Timer;
use App\Todo;
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

        if($request->frequency == 'No recurrence'){
            $request->frequency = null;
        }
        $task = Task::where('user_id', $user->id)->where('id', $id)->first();

        if (!$task) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $oldFrequency = $task->frequency;

        $task->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'notes' => $request->notes,
                'frequency' => $request->frequency
            ]
        );

        if ($task->frequency == null && $oldFrequency != null) {
            Todo::where('task_id', $task->id)->update([
                'frequency' => null
            ]);
        } // TODO
        elseif ($request->frequency != $oldFrequency) {

            $todo = new Todo([
                'user_id' => $user->id,
                'name' => $task->name,
                'description' => $task->description,
                'due_date_time' => Carbon::now($user->timezone)->startOfDay()->addHours(7)->format('Y-m-d H:i:s'),
                'task_id' => $task->id,
                'notes' => $task->notes,
                'frequency' => $task->frequency
            ]);
            $todo->save();
        }

        return $this->sendOkResponse($task->toArray(), 'Task updated successfully.');
    }

    public function store(Request $request)
    {
        if($request->frequency == 'No recurrence'){
            $request->frequency = null;
        }

        $user = Auth::user();
        $task = new Task([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
            'notes' => $request->notes,
            'frequency' => $request->frequency
        ]);
        $task->save();

        if ($request->frequency == 'every day') {
            $todo = new Todo([
                'user_id' => $user->id,
                'name' => $task->name,
                'description' => $task->description,
                'due_date_time' => Carbon::now($user->timezone)->startOfDay()->addHours(7)->format('Y-m-d H:i:s'),
                'task_id' => $task->id,
                'notes' => $task->notes,
                'frequency' => $task->frequency
            ]);
            $todo->save();
        }


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
