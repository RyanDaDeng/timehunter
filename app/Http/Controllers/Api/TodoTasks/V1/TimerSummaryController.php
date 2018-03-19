<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Task;
use App\Timer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TimerSummaryController extends Controller
{
    public function getTimerSummary()
    {
        return Timer::with('task')->where('user_id', 1)->whereNull('stopped_at')->first() ?? [];
    }

}
