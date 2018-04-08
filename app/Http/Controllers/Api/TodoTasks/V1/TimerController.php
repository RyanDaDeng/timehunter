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

class TimerController extends BaseController
{

    public function getRunningTimer()
    {
        $user = Auth::user();

        $timer = Timer::where('user_id', $user->id)->whereNull('stopped_at')->first();

        $timer = $timer ? $timer->toArray() : [];
        return $this->sendOkResponse($timer, 'Running timer retrieved successfully.');
    }


    public function startTimerByTimerId($timerId)
    {
        $user = Auth::user();

        $copyTimer = Timer::findOrFail($timerId);
        // stop all running task
        $this->stopTimerByUserId($user->id);

        $now = new Carbon();
        $timer = new Timer([
            'user_id' => $user->id,
            'started_at' => $now,
            'date' => $now->format('Y-m-d'),
            'name' => $copyTimer->name,
            'description' => $copyTimer->description
        ]);
        $timer->save();
        $timer = Timer::where('id', $timer->id)->first();

        $timer = $timer ? $timer->toArray() : [];
        return $this->sendOkResponse($timer, "Task: {$timer['name']} started.");
    }

    public function startTimerByTodoId($todoId)
    {
        $user = Auth::user();

        $todo = Todo::findOrFail($todoId);
        // stop all running task
        $this->stopTimerByUserId($user->id);

        $now = new Carbon();
        $timer = new Timer([
            'user_id' => $user->id,
            'started_at' => $now,
            'date' => $now->format('Y-m-d'),
            'name' => $todo->name,
            'todo_id' => $todo->id,
            'description' => $todo->description
        ]);
        $timer->save();
        $timer = Timer::where('id', $timer->id)->first();

        $timer = $timer ? $timer->toArray() : [];
        return $this->sendOkResponse($timer, "Task: {$timer['name']} started.");
    }


    public function startTimerByTaskId($taskId)
    {
        $user = Auth::user();

        $task = Task::findOrFail($taskId);
        // stop all running task
        $this->stopTimerByUserId($user->id);

        $now = new Carbon();
        $timer = new Timer([
            'user_id' => $user->id,
            'started_at' => $now,
            'date' => $now->format('Y-m-d'),
            'name' => $task->name,
            'task_id' => $task->id,
            'description' => $task->description
        ]);
        $timer->save();
        $timer = Timer::where('id', $timer->id)->first();

        $timer = $timer ? $timer->toArray() : [];
        return $this->sendOkResponse($timer, "Task: {$timer['name']} started.");
    }

    public function stopTimerByUserId($userId)
    {
        $user = Auth::user();
        if ($timer = Timer::where('user_id', $userId)->whereNull('stopped_at')->first()) {
            $now = new Carbon();
            $start = Carbon::parse($timer->started_at);

            $totalSeconds = $now->diffInSeconds($start);
            $timer->update(
                [
                    'stopped_at' => $now->format('Y-m-d H:i:s'),
                    'total_seconds' => $totalSeconds,
                    'total_duration' => gmdate("H:i:s", $totalSeconds)
                ]
            );
            $timer->date = Carbon::parse($timer->started_at, 'UTC')->timezone($user->timezone)->format('Y-m-d');
            $timer->started_at = Carbon::parse($timer->started_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $timer->stopped_at = Carbon::parse($timer->stopped_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            return $timer;
        }
        return null;

    }

    public function stopTimerById($id)
    {
        $user = Auth::user();
        if ($timer = Timer::where('id', $id)->first()) {
            $now = new Carbon();
            $start = Carbon::parse($timer->started_at);

            $totalSeconds = $now->diffInSeconds($start);
            $timer->update(
                [
                    'stopped_at' => $now->format('Y-m-d H:i:s'),
                    'total_seconds' => $totalSeconds,
                    'total_duration' => gmdate("H:i:s", $totalSeconds)
                ]
            );
            $timer->date = Carbon::parse($timer->started_at, 'UTC')->timezone($user->timezone)->format('Y-m-d');
            $timer->started_at = Carbon::parse($timer->started_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $timer->stopped_at = Carbon::parse($timer->stopped_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            return $timer;
        }
        return null;

    }

    public function stopTimer($id)
    {
        $user = Auth::user();
        $timer = $this->stopTimerById($id);
        if ($timer != null) {
            $timer->date = Carbon::parse($timer->started_at, 'UTC')->timezone($user->timezone)->format('Y-m-d');
            $timer->started_at = Carbon::parse($timer->started_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $timer->stopped_at = Carbon::parse($timer->stopped_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            return $this->sendOkResponse($timer, 'Running timer stopped successfully.');
        }
        return $this->sendBadRequest(null, 'Timer is not found.');

    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $now = new Carbon();
        $timers = Timer::query();
        $timers = $timers->where('user_id', $user->id)
            ->whereNotNull('stopped_at')
            ->where('started_at', '<=', $now->format('Y-m-d H:i:s'));

        if ($request->limit) {
            $timers = $timers->limit($this->limit);
        }
        if ($request->offset) {
            $timers = $timers->offset($this->offset);
        }
        $timers = $timers->orderBy('date', 'desc')->orderBy('stopped_at', 'desc')->get();

        foreach ($timers as $timer) {
            $timer->date = Carbon::parse($timer->started_at, 'UTC')->timezone($user->timezone)->format('Y-m-d');
            $timer->started_at = Carbon::parse($timer->started_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $timer->stopped_at = Carbon::parse($timer->stopped_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
        }

        return $this->sendOkResponse($timers->toArray(), 'Timers retrieved successfully.');
    }

    public function index_2(Request $request)
    {
        $user = Auth::user();
        $now = new Carbon();
        $timers = Timer::query();
        $timers = $timers->where('user_id', $user->id)
            ->whereNotNull('stopped_at')
            ->where('started_at', '<=', $now->format('Y-m-d H:i:s'));

        if ($request->limit) {
            $timers = $timers->limit($this->limit);
        }
        if ($request->offset) {
            $timers = $timers->offset($this->offset);
        }
        $timers = $timers->orderBy('date', 'desc')->orderBy('stopped_at', 'desc')->get();


        $result = [];
        foreach ($timers as $timer) {
            $timer->date = Carbon::parse($timer->date, 'UTC')->timezone($user->timezone)->formatLocalized('%a,%d %B');
            $timer->started_at = Carbon::parse($timer->started_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $timer->stopped_at = Carbon::parse($timer->stopped_at,
                'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
            $dateName = Carbon::parse($timer->date, 'UTC')->timezone($user->timezone)->formatLocalized('%a,%d %B');

            if (!isset($result[$timer->date])) {
                $result[$timer->date] = [
                    'total_timers' => 0,
                    'date_name' => $dateName,
                    'total_seconds' => 0,
                    'timers' => []
                ];
            }
            $timer->counter = $result[$timer->date]['total_timers'];
            $result[$timer->date]['total_seconds'] += $timer->total_seconds;
            $result[$timer->date]['timers'][] = $timer;
            $result[$timer->date]['total_timers'] += 1;
        }

        $new = [];
        foreach ($result as $key => $value) {
            $new[] = $value;
        }

        return $this->sendOkResponse($new, 'Timers retrieved successfully.');
    }

    public function summary(Request $request)
    {
        $user = Auth::user();
        $now = new Carbon();
        $timers = Timer::query();
        $timers = $timers->where('user_id', $user->id)
            ->whereNotNull('stopped_at')
            ->where('started_at', '<=', $now->format('Y-m-d H:i:s'));

        if ($request->limit) {
            $timers = $timers->limit($this->limit);
        }
        if ($request->offset) {
            $timers = $timers->offset($this->offset);
        }
        $timers = $timers->orderBy('date', 'desc')->get();


        $result = [];
        foreach ($timers as $timer) {
            $dateName = Carbon::parse($timer->date)->formatLocalized('%a,%d %B');

            if (!isset($result[$timer->date])) {
                $result[$timer->date] = [
                    'total_timers' => 0,
                    'date_name' => $dateName,
                    'total_seconds' => 0,
                    'timers' => []
                ];
            }
            $timer->counter = $result[$timer->date]['total_timers'];
            $result[$timer->date]['total_seconds'] += $timer->total_seconds;
            $result[$timer->date]['timers'][] = $timer;
            $result[$timer->date]['total_timers'] += 1;

        }

        return $this->sendOkResponse($result, 'Timers retrieved successfully.');
    }

    public function show($id)
    {
        return Timer::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $timer = Timer::findOrFail($id);

        $stop = Carbon::parse($request->stopped_at,$user->timezone)->timezone('UTC');
        $start = Carbon::parse($request->started_at,$user->timezone)->timezone('UTC');

        $totalSeconds = $stop->diffInSeconds($start);

        $timer->update([
            'name' => $request->name,
            'date' => Carbon::parse($request->started_at)->format('Y-m-d'),
            'started_at' => $start->format('Y-m-d H:i:s'),
            'stopped_at' => $stop->format('Y-m-d H:i:s'),
            'total_seconds' => $totalSeconds,
            'total_duration' => gmdate("H:i:s", $totalSeconds)
        ]);

        $timer->date = Carbon::parse($timer->started_at, 'UTC')->timezone($user->timezone)->format('Y-m-d');
        $timer->started_at = Carbon::parse($timer->started_at,
            'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');
        $timer->stopped_at = Carbon::parse($timer->stopped_at,
            'UTC')->timezone($user->timezone)->format('Y-m-d H:i:s');

        return $this->sendOkResponse($timer->toArray(), 'Timer updated successfully.');
    }

    public function destroy($id)
    {
        $task = Timer::findOrFail($id);
        $task->delete();
        return $this->sendOkResponse($task->toArray(), 'Timer successfully deleted.');
    }
}
