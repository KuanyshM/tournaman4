<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use App\Models\OrganizationFollowing;
use DB;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $data = [];
        if($user){
            $data = DB::table("trackings")
                        ->select("session_id","created_at")
                        ->groupBy("session_id","created_at")
                        ->orderByDesc("created_at")
                        ->get();

        }

        return view('organizations.index',compact('data'));
    }
    public function sessionsList($eventId)
    {
        if(!$this->eventStatisticsValidate($eventId)){
            return redirect('/events');
        }
        $user = auth()->user();
        $data = [];
        if($user){
            $data = DB::table("trackings")
                ->select("session_id",DB::raw('max(created_at) as created_at'))
                ->where("event_id","=",$eventId)
                ->groupBy("session_id")
                ->orderByDesc("created_at")
                ->get();

        }
    //print_r($data);
        return view('statistics.sessionsList',compact('data','eventId'));
    }


    public function statistics($eventId,$sessionId)
    {
        if(!$this->eventStatisticsValidate($eventId)){
            return redirect('/events');
        }

        $results = \Illuminate\Support\Facades\DB::select('SELECT currentTime, AVG(angry) AS avg_angry, AVG(disgusted) AS avg_disgusted,
       AVG(fearful) AS avg_fearful, AVG(happy) AS avg_happy, AVG(neutral) AS avg_neutral,
       AVG(sad) AS avg_sad, AVG(surprised) AS avg_surprised
FROM trackings
where event_id = '.$eventId.' and session_id = '.$sessionId.'
group by currentTime');

        $avg_angry = [];
        $avg_disgusted = [];
        $avg_happy = [];
        $avg_fearful = [];
        $avg_neutral = [];
        $avg_sad = [];
        $avg_surprised = [];


// Process the results
        foreach ($results as $k => $v) {
            $currentTime[] = $v->currentTime;
            $avg_angry[] = $v->avg_angry;
            $avg_disgusted[] = $v->avg_disgusted;
            $avg_fearful[] = $v->avg_fearful;
            $avg_happy[] = $v->avg_happy;
            $avg_neutral[] = $v->avg_neutral;
            $avg_sad[] = $v->avg_sad;
            $avg_surprised[] = $v->avg_surprised;
        }
        $currentTime = json_encode($currentTime);
        $avg_angry = json_encode($avg_angry);
        $avg_disgusted = json_encode($avg_disgusted);
        $avg_fearful = json_encode($avg_fearful);
        $avg_happy = json_encode($avg_happy);
        $avg_neutral= json_encode($avg_neutral);
        $avg_sad = json_encode($avg_sad);
        $avg_surprised = json_encode($avg_surprised);
        return view('statistics.session', compact('sessionId','currentTime','avg_angry','avg_disgusted','avg_fearful','avg_happy','avg_neutral','avg_sad','avg_surprised'));


    }


    public function statisticsEvent($eventId)
    {
        if(!$this->eventStatisticsValidate($eventId)){
            return redirect('/events');
        }
        $results = \Illuminate\Support\Facades\DB::select('SELECT currentTime, AVG(angry) AS avg_angry, AVG(disgusted) AS avg_disgusted,
       AVG(fearful) AS avg_fearful, AVG(happy) AS avg_happy, AVG(neutral) AS avg_neutral,
       AVG(sad) AS avg_sad, AVG(surprised) AS avg_surprised
FROM trackings
where event_id = '.$eventId.'
group by currentTime');

        $avg_angry = [];
        $avg_disgusted = [];
        $avg_happy = [];
        $avg_fearful = [];
        $avg_neutral = [];
        $avg_sad = [];
        $avg_surprised = [];


// Process the results
        foreach ($results as $k => $v) {
            $currentTime[] = $v->currentTime;
            $avg_angry[] = $v->avg_angry;
            $avg_disgusted[] = $v->avg_disgusted;
            $avg_fearful[] = $v->avg_fearful;
            $avg_happy[] = $v->avg_happy;
            $avg_neutral[] = $v->avg_neutral;
            $avg_sad[] = $v->avg_sad;
            $avg_surprised[] = $v->avg_surprised;
        }
        $currentTime = json_encode($currentTime);
        $avg_angry = json_encode($avg_angry);
        $avg_disgusted = json_encode($avg_disgusted);
        $avg_fearful = json_encode($avg_fearful);
        $avg_happy = json_encode($avg_happy);
        $avg_neutral= json_encode($avg_neutral);
        $avg_sad = json_encode($avg_sad);
        $avg_surprised = json_encode($avg_surprised);
        return view('statistics.statistics', compact('eventId','currentTime','avg_angry','avg_disgusted','avg_fearful','avg_happy','avg_neutral','avg_sad','avg_surprised'));


    }
    public function eventStatisticsValidate($eventId): bool{

        $event = Event::find($eventId);
        $user = auth()->user();

        if (!$user->can("settings-list") && $event->user_id != $user->id){

            return false;

        }
        return true;


    }
}
