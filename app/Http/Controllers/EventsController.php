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
        $events = DB::table('events')
                   ->select('*')->get();
        $finalReturnValue = [];
        if(count($events) > 0){
            foreach($events as $event){
                $workshops = DB::table('workshops')
                ->select('*')
                ->where('event_id', $event->id)
                ->get();
                $event->workshops = $workshops;
                array_push($finalReturnValue, $event);
            }
        }
        return response()->json($finalReturnValue);
    }

    public function getWarmUpEvents() {
        $jsonVal = '{ "name" : "Laravel convention 2020", "name" : "Laravel convention 2021", "name" : "React convention 2021"}';
        
        return response()->json(json_decode($jsonVal));
    }

    public function getFutureEventsWithWorkshops() {
        throw new \Exception('implement in coding task 2');
    }
}
