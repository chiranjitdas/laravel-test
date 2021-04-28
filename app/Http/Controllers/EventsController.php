<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;


class EventsController extends BaseController
{
    public function getEventsWithWorkshops() {
        // throw new \Exception('implement in coding task 1');
        $workshops = DB::table('workshops')
                   ->select('*')
                   ->groupBy('event_id');
        $users = DB::table('events')
        ->joinSub($workshops, 'workshops', function ($join) {
            $join->on('events.id', '=', 'workshops.event_id');
        })->get();
        return response()->json(json_decode($users));
    }

    public function getWarmUpEvents() {
        $jsonVal = '{ "name" : "Laravel convention 2020", "name" : "Laravel convention 2021", "name" : "React convention 2021"}';
        
        return response()->json(json_decode($jsonVal));
    }

    public function getFutureEventsWithWorkshops() {
        throw new \Exception('implement in coding task 2');
    }
}
