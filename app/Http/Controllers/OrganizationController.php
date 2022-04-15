<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationFollowing;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:organization-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if($user->can("settings-list")){
            $data = Organization::orderBy('id', 'desc')->paginate(5);
        }else{
            $data = Organization::orderBy('id', 'desc')->where("id",$user->organization_id)->paginate(5);
        }

        return view('organizations.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organizations.create');
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

        $organization = Organization::create($input);

        $user = auth()->user();
        $user->update(['organization_id'=>$organization->id]);

        return redirect()->route('organizations.index')
            ->with('success','Organization created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::withCount('followers')->find($id);

        return view('organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);

        return view('organizations.edit',compact('organization'));
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

        $Organization = Organization::find($id);

        $Organization->update($request->all());

        return redirect()->route('organizations.index')
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
        Organization::find($id)->delete();

        return redirect()->route('organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
    public function follow()
    {

        $organization = Organization::find(request()->organization_id ?? 0 );
        $user = auth()->user();
        $userFollow= OrganizationFollowing::select('*')
            ->where('organization_id', '=', $organization->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if(!$userFollow){
            $follow = new OrganizationFollowing();
            $follow->organization_id = $organization->id;
            $follow->user_id = $user->id;
            $follow->save();
        }else{
            $userFollow->delete();
        }

        return redirect()->back();

    }
}
