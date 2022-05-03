<?php
namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationFollowing;
use DB;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
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
            $data = User::orderBy('id', 'desc')->paginate(5);
        }else{
            $data = User::orderBy('id', 'desc')->where("organization_id",$user->organization_id)->paginate(5);
        }

        return view('users.index', compact('data'));
    }
    public function rankings(Request $request)
    {
        $data = User::orderBy('id', 'desc')->paginate(3);

        return view('users.rankings', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        unset($roles['admin']);
        if(auth()->user()->can("settings-list")){
            $organizations = Organization::pluck('name','name')->all();

        }else{
            $organizations = Organization::where('id',auth()->user()->organization_id)->pluck('name','name')->all();

        }


        return view('users.create', compact('roles'),compact('organizations'));
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(auth()->user()->can('settings-list')){
            $organization = DB::table('organizations')->where('name', $input['organizations'][0])->first();
        }else{
            $organization = Organization::find(auth()->user()->organization_id);
        }

        $input['password'] = Hash::make($input['password']);
        $input['organization_id'] = $organization->id;

       $user = User::create($input);
       $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can("settings-list") || $id==auth()->user()->id ){
            $user = User::find($id);
            $roles = Role::pluck('name', 'name')->all();
            unset($roles['admin']);
            $userRole = $user->roles->pluck('name', 'name')->all();

            return view('users.edit', compact('user', 'roles', 'userRole'));
        }else{
            $user = User::find($id);

            return view('users.show', compact('user'));
        }

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
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'roles' => 'required'
        ]);

        $input = $request->all();

        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }


    public function profile()
    {
        $user = User::withCount('participations')->withCount('participations')->where('id',auth()->user()->id)->first();

        return view('users.show', compact('user'));
    }

    public function follow()
    {
        $organization = Organization::find(request()->organization_id ?? 0 );
        $user = auth()->user();
        $userOrganization = OrganizationFollowing::select('*')
            ->where('event_id', '=', $organization->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if(!$userOrganization){
            $userOrganization = new OrganizationFollowing();
            $userOrganization->organization_id = $organization->id;
            $userOrganization->user_id = $user->id;
            $userOrganization->save();
        }else{
            $userOrganization->delete();
        }

        return redirect()->back();


    }
}
