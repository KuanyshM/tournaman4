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
            <div class="card-header">Members of {{$team->name}}
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
                        @foreach ($team->members() as $key => $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('users.show',$user->id) }}">Show</a>

                                @if($team->author_user_id==auth()->user()->id)
                                        <input onclick='remove("team_id_{{$team->id}}_user_id_{{$user->id}}")' type="button" value="Remove" class="btn btn-danger">

                                        <form id="team_id_{{$team->id}}_user_id_{{$user->id}}" action="{{ url('/teams/members/remove') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="team_id"
                                                   value="{{ $team->id }}">
                                            <input type="hidden" name="user_id"
                                                   value="{{ $user->id }}">

                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    function remove(id){
        var form = document.getElementById(id);

        form.submit();
    }

</script>
