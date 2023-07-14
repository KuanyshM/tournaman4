<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;

class VideoController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $videos = array();
        for ($i = 0; $i < sizeof($events); $i++) {
            $videos[$i]["id"] = $events[$i]->id;
            $videos[$i]["title"] = $events[$i]->title;
            $videos[$i]["videoURL"] = "http://www.youtube.com/watch?v=".$events[$i]->link;
            $videos[$i]["imageURL"] = "https://i.ytimg.com/vi/".$events[$i]->link."/hqdefault.jpg";

        }

        return response()->json($videos);
    }
}
