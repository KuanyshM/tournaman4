<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\UserTeam;
use Illuminate\Http\Request;

class UserTeamController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = Team::find(request()->team_id);
        if($team){
            $userTeams = UserTeam::where('to_user_id','=',$team->author_user_id)
                ->where('from_user_id','=',auth()->user()->id)
                ->where('team_id','=',$team->id)->get();

            if($userTeams->count()==0){
                $userTeam = new UserTeam();
                $userTeam->to_user_id = $team->author_user_id;
                $userTeam->from_user_id = auth()->user()->id;
                $userTeam->status_id = 1;
                $userTeam->team_id = $team->id;

                $userTeam->save();
                return redirect("teams/{$team->id}")->with('info',"Success");

            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
