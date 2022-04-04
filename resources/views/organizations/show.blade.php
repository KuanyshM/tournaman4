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
            <div class="card-header">Organization
                @can('organization-create')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('organizations.index') }}">Back</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <div class="lead">
                    <strong>Name:</strong>
                    {{ $organization->name }}
                </div>
                <div class="lead">
                    <strong>Description:</strong>
                    {{ $organization->description }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
