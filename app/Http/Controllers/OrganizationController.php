<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Post;
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
        $this->middleware('permission:organization-list|organization-create|organization-edit|organization-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:organization-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:organization-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:organization-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Organization::latest()->paginate(5);

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

        Organization::create($input);

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
        $organization = Organization::find($id);

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
}
