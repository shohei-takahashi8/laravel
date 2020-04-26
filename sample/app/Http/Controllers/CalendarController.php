<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Calendar;
use App\Folder;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request) {

        $taskList = Auth::user()->tasks()->get();
        $today = Carbon::today();

        $cal = new Calendar($taskList, $today);

        $tag = $cal->showCalendarTag($request->month, $request->year);

        return view('calendars.index', ['cal_tag' => $tag]);
        
    }

}
