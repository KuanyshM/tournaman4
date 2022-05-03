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
            <div class="card-header">Users
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('/events/event-participate/status')}}">
                    @csrf
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>


                    @foreach ($data as $key => $participation)
                            <tr>
                                <td>{{ $participation->user->id }}</td>
                                <td>{{ $participation->user->name }}</td>
                                <td>{{ $participation->user->email }}</td>
                                <td>
                                    <select name = "participations[{{$participation->user->id}}][status]" class="form-control">
                                        @foreach($statuses as $status)
                                            <option @if($status->id==$participation->status_id) selected @endif value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>



                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>
                    <button class="btn btn-success" type="submit">Update</button>
                </form>
                {{ $data->render() }}
            </div>
        </div>
    </div>
</div>
@endsection
