<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Task;
use App\Timer;
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

    public function startTimerByTaskId($taskId)
    {
        $user = Auth::user();

        $task = Task::findOrFail($taskId);
        // stop all running task
        Timer::where('user_id', $user->id)->whereNull('stopped_at')->update(['stopped_at' => new Carbon()]);

        $now = new Carbon();
        $timer = new Timer([
            'user_id' => $user->id,
            'started_at' => $now,
            'date' => $now->format('Y-m-d'),
            'name' => $task->name,
            'description' => $task->description
        ]);
        $timer->save();
        $timer = Timer::where('id', $timer->id)->first();

        $timer = $timer?$timer->toArray():[];
        return $this->sendOkResponse($timer, "Task: {$timer['name']} started.");
    }


    public function stopTimer($id)
    {
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
            return $this->sendOkResponse($timer, 'Running timer stopped successfully.');
        }
        return $this->sendBadRequest($timer, 'Timer is not found.');

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
        $task = Timer::findOrFail($id);
        $task->update($request->all());

        return $task;
    }

    public function destroy($id)
    {
        $task = Timer::findOrFail($id);
        $task->delete();
        return '';
    }
}
