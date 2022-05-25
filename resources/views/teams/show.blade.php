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
            <div class="card-header">Teams
                @can('settings-list')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('teams.index') }}">Back</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                {{count($team->members())}}
                @foreach($team->members() as $user)
                    {{$user->name}}
                @endforeach
                <div class="lead">
                    <strong>Name:</strong>
                    {{ $team->name }}
                </div>
                <div class="lead">
                    <strong>Description:</strong>
                    {{ $team->description }}
                </div>
                <div class="lead">
                    <p>
                    <form action="{{ url('/teams/create') }}" method="post">
                        @csrf
                        <input type="hidden" name="team_id"
                               value="{{ $team->id }}">
                        <p class="card-img-bottom">
                            <button  type="submit" class="btn btn-block btn-info float-right"><i class="fa fa-thumbs-up">Join </i> </button>
                        </p>
                    </form>
                    </p>
                    <p class="card-img-bottom">
                        <a href="{{url("teams/$team->id/members")}}">
                            <button  type="submit" class="btn btn-block btn-info float-right">Members </button>
                        </a>
                    </p>
                    <p class="card-img-bottom">
                        <a href="{{url("teams/$team->id/requests")}}">
                            <button  type="submit" class="btn btn-block btn-info float-right">Requests </button>
                        </a>
                    </p>
                </div>
            </div>
        </div>




    </div>
</div>
@endsection
