<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class TodosController extends BaseController
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $todos = Todo::query();
        $todos = $todos->where('user_id', $user->id);

        if ($request->due_date_time_from) {
            $todos = $todos->where('due_date_time', '>=', $request->due_date_time_from);
        }

        if ($request->due_date_time_to) {
            $todos = $todos->where('due_date_time', '<=', $request->due_date_time_to);
        }

        $todos = $todos->get();

        $result = $todos ? $todos->toArray() : [];

        return $this->sendOkResponse($result, 'Todos retrieved successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();

        $todo = Todo::where('user_id', $user->id)->where('id', $id)->first();

        if (!$todo) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        return $this->sendOkResponse($todo->toArray(), 'Todos retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $todo = Todo::where('user_id', $user->id)->where('id', $id)->first();

        if (!$todo) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $todo->update(
            [
                'description' => $request->description,
                'due_date_time' => $request->due_date_time,
                'task_id' => $request->task_id,
                'name' => $request->name,
                'notes' => $request->notes
            ]
        );

        return $this->sendOkResponse($todo->toArray(), 'Todo updated successfully.');
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $todo = new Todo([
            'user_id' => $user->id,
            'description' => $request->description,
            'due_date_time' => Carbon::parse($request->due_date_time)->format('Y-m-d H:i:s'),
            'task_id' => $request->task_id,
            'notes' => $request->notes,
            'name' => $request->name
        ]);
        $todo->save();

        return $this->sendOkResponse($todo->toArray(), 'Todo created successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $todo = Todo::where('user_id', $user->id)->where('id', $id)->first();

        if (!$todo) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $todo->delete();
        return $this->sendOkResponse($todo->toArray(), 'Todo successfully deleted.');
    }


    public function done($id)
    {
        $user = Auth::user();

        $todo = Todo::where('user_id', $user->id)->where('id', $id)->first();
        if (!$todo) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        if($todo->is_done == true){
            return $this->sendBadRequest('Todo had already been finished!');
        }
        $todo->is_done = true;
        $todo->save();

        if ($todo->frequency == 'every day') {
            $todo = new Todo([
                'user_id' => $user->id,
                'name' => $todo->name,
                'description' => $todo->description,
                'due_date_time' => Carbon::parse($todo->due_date_time)->startOfDay()->addday()->addHours(7)->format('Y-m-d H:i:s'),
                'task_id' => $todo->task_id,
                'notes' => $todo->notes,
                'frequency' => $todo->frequency
            ]);
            $todo->save();
        }

        return $this->sendOkResponse($todo->toArray(), 'Todo is marked as done.');
    }

}
