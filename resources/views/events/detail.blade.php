<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail</title>
</head>
<body>
<div style="background-image: url('{{url("images/$event->photo")}}');" class="backroundDiv"></div>

    @extends('layouts.app')

    @section('content')

        <div class="container">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-8">
                        <img src="{{url("images/$event->photo")}}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text">
                                {{ $event->body }}
                            </p>
                            <p class="card-text">
                                Category: <b>{{ $event->category->name }}</b>
                            </p>
                            <p class="card-text"><small class="text-muted">Last updated {{ $event->updated_at}}</small></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                             <h5 class="card-title">Quick details</h5>
                                    <div class="">
                                        <label>Registration start date</label><br>
                                        <p class="form-control">{{$event->reg_start_date}}</p>
                                    </div>
                                    <div class=" ">
                                        <label>Registration end date</label><br>
                                        <p class="form-control">{{$event->reg_end_date}}</p>

                                    </div>
                                    <div class="">
                                        <label>Event Start date</label><br>
                                        <p class="form-control">{{$event->start_date}}</p>

                                    </div>
                                    <div class=" ">
                                        <label>Event end date</label><br>
                                        <p class="form-control">{{$event->end_date}}</p>
                                    </div>
                                    <div class="">
                                        <label>Number of teams/participants</label>
                                        <p class="form-control">{{$event->numberof_participants}}</p>
                                    </div>
                                    <div class="">
                                        <label>Price</label>
                                        <p class="form-control">{{$event->price}}</p>
                                    </div>
                                    <div class="">
                                        <label>Address</label>
                                        <p class="form-control">{{$event->address}}</p>
                                    </div>
                                    <div>
                                        <label>Age Restriction</label>
                                        <div  class="row">
                                            <div class="col-md-2">
                                                <label>From</label>
                                                <p class="form-control">{{$event->age_from}}</p>
                                            </div>

                                            <div class="col-md-2">
                                                <label>To</label>
                                                <p class="form-control">{{$event->age_to}}</p>
                                            </div>
                                    </div>
                                    </div>
                                    <div >
                                        <label>Format</label>
                                        @if($event->format_id==1)
                                            <p class="form-control">Live Event</p>
                                        @else
                                            <p class="form-control">Online Event</p>
                                        @endif
                                    </div>
                                    <div  >
                                        <label>FAQ</label>
                                        <p class="form-control text-justify">{{$event->faq}}</p>
                                    </div>

                        </div>
                        <div class="col-md-4">
                            <div  class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <a href="{{ url("/organizations/".$event->user->organization_id) }}" class="card-link">
                                        <h5 class="card-title">
                                            {{ $event->user->organization->name}}
                                        </h5>
                                    </a>

                                    <div class="form-control">
                                        <a href="{{$event->user->organization->facebook}}"><img src="{{url("social-media/facebook.svg")}}" alt="icon" width="32" height="32"></a>
                                        <a href="{{$event->user->organization->facebook}}"><img src="{{url("social-media/twitter.svg")}}" alt="icon" width="32" height="32"></a>
                                    </div>

                                    <form class="pt-2"  action="{{ url('/organizations/organization-follow') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="organization_id"
                                               value="{{ $event->user->organization_id }}">
                                        <p class="card-img-bottom">
                                            <button  type="submit" class="btn btn-block btn-info float-right"><i class="fa fa-thumbs-up">{{ __('messages.Follow') }}  {{ $organization->followers_count }}</i> </button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                                @auth()
                                    @if($event->user_id==auth()->user()->id)
                                        <div  class="card mt-3" style="width: 18rem;">
                                            <div class="card-body">
                                                <p class="card-subtitle">Manage</p>
                                                <p>
                                                    <button class="btn btn-success"  onclick="window.location='{{ url("/events/edit/$event->id") }}';" >Edit</button>
                                                </p>
                                                <p>
                                                    <button class="btn btn-success"  onclick="window.location='{{ url("/events/participants/$event->id") }}';" >Participants</button>
                                                </p>
                                                <p>
                                                    <a href="{{ url("/events/delete/$event->id") }}"
                                                       class="btn btn-warning">
                                                        {{ __('messages.Delete') }}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                        </div>
                    </div>

                @if($event->eventType==1)
                        <p>
                        <form action="{{ url('/events/event-participate') }}" method="post">
                            @csrf
                            <input type="hidden" name="event_id"
                                   value="{{ $event->id }}">
                            <p class="card-img-bottom">
                                <button  type="submit" class="btn btn-block btn-info float-right"><i class="fa fa-thumbs-up">{{ __('messages.Participate') }} {{ $event->participations_count }}</i> </button>
                            </p>
                        </form>
                        </p>
                    @else
                        @if(count($myTeams)==0)
                            <p>
                                <a href="{{url('teams/create')}}">Add new team to participate</a>
                            </p>
                        @else
                            <div class="col-md-8">
                                <form action="{{ url('/events/event-participate-team') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="event_id"
                                           value="{{ $event->id }}">
                                    <select required name="team_id" class=" form-control">
                                        @foreach($myTeams as $t)
                                            <option class="form-control" value="{{$t->team->id}}">{{$t->team->name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-3 card-img-bottom">
                                        <button  type="submit" class="btn btn-block btn-info float-right"><i class="fa fa-thumbs-up">{{ __('messages.Participate') }} {{ $event->participations_count }}</i> </button>
                                    </p>

                                </form>
                            </div>

                        @endif
                    @endif
                            <p>
                            <form action="{{ url('/events/event-like') }}" method="post">
                                @csrf
                                <input type="hidden" name="event_id"
                                       value="{{ $event->id }}">
                                <p class="card-img-bottom">
                                    <button  type="submit" class="btn btn-block btn-primary float-right"><i class="fa fa-thumbs-up">Like {{ $event->likes_count }}</i> </button>

                                </p>

                            </form>
                            </p>

                </div>
            </div>

            <ul class="list-group">
                <li class="list-group-item active">
                   <b>Comments ({{ count($event->comments) }})</b>
                </li>
                @foreach ($event->comments as $comment)
                    <li class="list-group-item">
                        @if(Gate::allows('comment-delete', $comment) )
                            <a href="{{ url("/comments/delete/$comment->id") }}"
                               class="btn-close float-end">
                            </a>
                        @endif
                        {{ $comment->content }}
                        <div class="small mt-2">
                            By <b>{{ $comment->user->name }}</b>,
                            {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </li>
                @endforeach
            </ul>

            @auth
                <form action="{{ url('/event-comments/add') }}" method="post">
                    @csrf
                    <input type="hidden" name="event_id"
                        value="{{ $event->id }}">
                    <textarea required name="content" class="form-control mb-2" placeholder="New Event Comment"></textarea>

                    <input type="submit" value="Add Event Comment" class="btn btn-secondary">
                </form>
            @endauth
        </div>
    @endsection
</body>
</html>
