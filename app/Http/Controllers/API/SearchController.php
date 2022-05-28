<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Team;
use App\Models\User;

class SearchController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $searchKey = request()->search;
        $events = Event::where('title','like',"%".$searchKey."%")
            ->orWhere('body','like',"%".$searchKey."%")
            ->limit(3)
            ->orderByDesc('id')
            ->get();
        $users = User::where('name','like',"%".$searchKey."%")
            ->orWhere('email','like',"%".$searchKey."%")
            ->limit(3)
            ->orderByDesc('id')
            ->get();
        $teams = Team::where('name','like',"%".$searchKey."%")
            ->orWhere('description','like',"%".$searchKey."%")
            ->limit(3)
            ->orderByDesc('id')
            ->get();
        $organization = Organization::where('name','like',"%".$searchKey."%")
            ->orWhere('description','like',"%".$searchKey."%")
            ->limit(3)
            ->orderByDesc('id')
            ->get();

        $data['events']=$events;
        $data['users']=$users;
        $data['teams']=$teams;
        $data['organizations']=$organization;

//sleep(1.5);
        return $this->sendResponse($data, 'List of results');
    }
}
