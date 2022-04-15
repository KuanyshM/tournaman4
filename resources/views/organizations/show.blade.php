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
                @can('settings-list')
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
                <div class="lead">
                    <a href="{{ url("/events/organization/$organization->id") }}"
                       class="btn btn-success">
                        Tournaments
                    </a>
                    <p>
                    <form action="{{ url('/organizations/organization-follow') }}" method="post">
                        @csrf
                        <input type="hidden" name="organization_id"
                               value="{{ $organization->id }}">
                        <p class="card-img-bottom">
                            <button  type="submit" class="btn btn-block btn-info float-right"><i class="fa fa-thumbs-up">{{ __('messages.Follow') }}  {{ $organization->followers_count }}</i> </button>
                        </p>
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
