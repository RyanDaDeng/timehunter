<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Task;
use App\Timer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{
    public function getRunningTimer()
    {
        return Timer::where('user_id', 1)->whereNull('stopped_at')->first() ?? [];
    }

    public function startTimerByTaskId($taskId)
    {

        $task = Task::findOrFail($taskId);
        // stop all running task
        Timer::where('user_id', 1)->whereNull('stopped_at')->update(['stopped_at' => new Carbon()]);

        $now = new Carbon();
        $timer = new Timer([
            'user_id' => 1,
            'started_at' => $now,
            'date' => $now->format('Y-m-d'),
            'name' => $task->name,
            'description' => $task->description
        ]);
        $timer->save();

        return Timer::where('id', $timer->id)->first() ??[];
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
                    'total_duration'=> gmdate("H:i:s", $totalSeconds)
                ]
            );
        }
        return $timer;
    }


    public function index()
    {
        $now = new Carbon();
        $timers = Timer::where('user_id', 1)
            ->whereNotNull('stopped_at')
            ->where('started_at', '<=', $now->format('Y-m-d H:i:s'))
            ->get();

        return $timers;
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
