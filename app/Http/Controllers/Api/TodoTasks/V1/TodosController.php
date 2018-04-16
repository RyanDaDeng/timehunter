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

        $todos = Todo::with('project');
        $todos = $todos->where('user_id', $user->id);

        $dateFrom = Carbon::parse($request->due_date_time_from,
            $user->timezone)->timezone('UTC')->format('Y-m-d H:i:s');
        $dateTo = Carbon::parse($request->due_date_time_to,
            $user->timezone)->timezone('UTC')->format('Y-m-d H:i:s');

        if ($request->due_date_time_from) {
            $todos = $todos->where('due_date_time', '>=', $dateFrom);
        }

        if ($request->due_date_time_to) {
            $todos = $todos->where('due_date_time', '<=', $dateTo);
        }

        $todos = $todos->orderBy('due_date_time', 'asc')->get();


        foreach ($todos as $todo) {
            $todo->due_date_time = Carbon::parse($todo->due_date_time,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
        }

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

        $todo->due_date_time = Carbon::parse($todo->due_date_time,
            'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');

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
                'due_date_time' => Carbon::parse($request->due_date_time,
                    $user->timezone)->timezone('UTC')->format('Y-m-d H:i:s'),
                'task_id' => $request->task_id,
                'name' => $request->name,
                'notes' => $request->notes,
                'project_id' => $request->project_id,
                'frequency' => $request->frequency,
                'priority_level' => $request->priority_level
            ]
        );

        $todo->due_date_time = Carbon::parse($todo->due_date_time,
            'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');

        return $this->sendOkResponse($todo->toArray(), 'Todo updated successfully.');
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $todo = new Todo([
            'user_id' => $user->id,
            'due_date_time' => Carbon::parse($request->due_date_time,
                $user->timezone)->timezone('UTC')->format('Y-m-d H:i:s'),
            'task_id' => $request->task_id,
            'is_done' => false,
            'notes' => $request->notes,
            'name' => $request->name,
            'project_id' => $request->project_id,
            'frequency' => $request->frequency,
            'priority_level' => $request->priority_level
        ]);
        $todo->save();


        $todo->due_date_time = Carbon::parse($todo->due_date_time,
            'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');

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

        $todo->due_date_time = Carbon::parse($todo->due_date_time,
            'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');

        return $this->sendOkResponse($todo->toArray(), 'Todo successfully deleted.');
    }


    public function done($id)
    {
        $user = Auth::user();

        $todo = Todo::where('user_id', $user->id)->where('id', $id)->first();
        if (!$todo) {
            return $this->sendBadRequest('Resource cannot be found.');
        }


        if ($todo->is_done == true) {
            $todo->is_done = false;
            $todo->save();
            $result = [
                'done' => $todo->toArray(),
                'newTodo' => null
            ];
            return $this->sendOkResponse($result, 'Todo is marked as Uncompleted.');
        }


        $newTodo = null;
        if ($todo->frequency == 'every day') {

            $newTodo = new Todo($todo->toArray());
            $newTodo->due_date_time = Carbon::parse($todo->due_date_time)->startOfDay()->addday()->addHours(7)->format('Y-m-d H:i:s');
            $newTodo->id = null;
            $newTodo->is_done = 0;
            $newTodo->save();
        }
        $todo->is_done = true;
        $todo->frequency = null;
        $todo->save();

        $result = [
            'done' => $todo->toArray(),
            'newTodo' => $newTodo == null ? null : $newTodo->toArray()
        ];

        return $this->sendOkResponse($result, 'Todo is marked as done.');
    }


    public function getNotDone(Request $request)
    {
        $user = Auth::user();

        if($request->is_expired == "false"){
            $dateFrom = Carbon::parse($request->due_date_time_from,$user->timezone)->timezone('UTC');
            $dateTo = Carbon::parse($request->due_date_time_to,$user->timezone)->timezone('UTC');

            $todos = Todo::where('user_id', $user->id)->where('due_date_time', '>=',
                $dateFrom->format('Y-m-d H:i:s'))->where('due_date_time', '<=',
                $dateTo->format('Y-m-d H:i:s'))->orderBy('due_date_time', 'asc')->get();
        }else{
            $now = Carbon::now('UTC');
            $todos = Todo::where('user_id', $user->id)->where('is_done',0)->where('due_date_time', '<=',
                $now->format('Y-m-d H:i:s'))->orderBy('due_date_time', 'asc')->get();
        }

        $result = [
            1 => [],
            2 => [],
            3 => [],
            4 => []
        ];
        foreach ($todos as $todo) {
            $todo->due_date_time = Carbon::parse($todo->due_date_time,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $result[$todo->priority_level][] = $todo->toArray();

        }

        return $this->sendOkResponse($result, 'Incomplete Todo retrieved.');
    }


    public function getDoneForTimeline()
    {
        $user = Auth::user();
        $now = new Carbon();
        $now->setTimezone('UTC')->timezone($user->timezone);

        $todos = Todo::where('user_id', $user->id)->where('is_done', 1)->orderBy('due_date_time', 'desc')->get();

        $result = [];
        foreach ($todos as $todo) {
            $dueDateTime = $todo->due_date_time = Carbon::parse($todo->due_date_time,
                'UTC')->timezone($user->timezone);
            if (!isset($result[$dueDateTime->year])) {
                $result[$dueDateTime->year] = [];
            }

            $result[$dueDateTime->year][] = [
                'name' => $todo->name,
                'time' => $dueDateTime->copy()->format('l jS F H:i:s')
            ];
        }

        return $this->sendOkResponse($result, 'All done Todo retrieved.');
    }


    public function updatePriority(Request $request, $id)
    {
        $user = Auth::user();

        $todo = Todo::where('user_id', $user->id)->where('id', $id)->first();
        if (!$todo) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $todo->priority_level = $request->priority_level;
        $todo->save();

        return $this->sendOkResponse($todo->toArray(), 'Todo is marked as done.');
    }


}
