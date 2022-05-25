<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamStatus;
use App\Models\UserTeam;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Team::orderBy('id', 'desc')->paginate(5);


        return view('teams.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',

        ]);
        $input = $request->except(['_token']);
        $input['verified'] = false;
        $input['author_user_id'] = auth()->user()->id;

        $team = Team::create($input);
        if($team){

            $userTeams = UserTeam::where('to_user_id','=',$team->author_user_id)
                ->where('from_user_id','=',auth()->user()->id)
                ->where('team_id','=',$team->id)->get();
            if($userTeams->count()==0){

                $userTeam = new UserTeam();
                $userTeam->to_user_id = $team->author_user_id;
                $userTeam->from_user_id = auth()->user()->id;
                $userTeam->status_id = 2;
                $userTeam->team_id = $team->id;
                $userTeam->save();
            }
        }


        return redirect()->route('teams.index')
            ->with('success','Team created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::with('userTeam')->find($id);
        $teamStatus = TeamStatus::get();

        return view('teams.show',[
            'team' => $team,
            'teamStatus' => $teamStatus
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::find($id);

        return view('teams.edit',compact('team'));
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $team = Team::find($id);

        $team->update($request->all());

        return redirect()->route('teams.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Team::find($id)->delete();
        UserTeam::where('team_id','=',$id)->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Team deleted successfully.');
    }
    public function members($id)
    {
        $team = Team::where('id','=',$id)->first();



        return view('teams.members',compact('team'));
    }
    public function requests($id)
    {
        $team = Team::where('id','=',$id)->first();



        return view('teams.requests',compact('team'));
    }
    public function removeTeamMember()
    {
        $id = request()->team_id;
        $idUser = request()->user_id;
        UserTeam::where('team_id','=',$id)
            ->where('from_user_id','=',$idUser)->delete();


        return redirect()->back()->with('success', 'Team deleted successfully.');
    }
    public function removeTeamRequest()
    {
        $id = request()->team_id;
        $idUser = request()->user_id;
        UserTeam::where('team_id','=',$id)
            ->where('from_user_id','=',$idUser)->delete();

        return redirect()->back()->with('success', 'Request deleted successfully.');
    }
    public function acceptTeamRequest(){
        $id = request()->team_id;
        $idUser = request()->user_id;
        UserTeam::where('team_id','=',$id)
            ->where('from_user_id','=',$idUser)->update(['status_id' => 2]);

        return redirect()->back()->with('success', 'Request deleted successfully.');
    }
}
