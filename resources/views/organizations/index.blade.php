@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-header">Organizations
                @if(Gate::allows('organization-create'))
                @endif
                @can('organization-create')
                    <span class="float-right">
                        @if( auth()->user()->can("settings-list"))
                            <a class="btn btn-secondary" href="{{ route('settings.index') }}">Settings</a>
                        @endif
                        <a class="btn btn-primary" href="{{ route('organizations.create') }}">Add Organization</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $organization)
                            <tr>
                                <td>{{ $organization->id }}</td>
                                <td>{{ $organization->name }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('organizations.show',$organization->id) }}">Show</a>
                                    @can('organization-edit')
                                        <a class="btn btn-primary" href="{{ route('organizations.edit',$organization->id) }}">Edit</a>
                                    @endcan
                                    @can('organization-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['organizations.destroy', $organization->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
