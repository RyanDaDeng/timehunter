<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Task;
use App\Timer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{

    public function index()
    {
        return Task::all();
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update(
            [
                'name' => $request->name,
                'description' => $request->description
            ]
        );

        return $task;
    }

    public function store(Request $request)
    {
        $task = new Task([
            'user_id' => 1,//todo
            'name' => $request->name,
            'description' => $request->description
        ]);
        $task->save();
        return $task;
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return '';
    }
}
