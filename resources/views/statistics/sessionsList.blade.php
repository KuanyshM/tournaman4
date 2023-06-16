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
            <br>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>SessionID</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $session)

                        <tr>
                            <th>
                                <a href="{{url("/events/statistics/".$eventId."/session/".$session->session_id)}}">
                                    {{$session->session_id}}
                                </a>
                            </th>
                            <th>{{$session->created_at}}</th>

                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
