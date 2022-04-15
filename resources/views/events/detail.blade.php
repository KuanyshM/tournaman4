<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $event->title }}
                    </h5>
                    <div class="card-subtitle mb-2 text-muted small">
                        {{ $event->created_at->diffForHumans() }},
                        Category: <b>{{ $event->category->name }}</b>
                    </div>
                    <p class="card-text">
                        {{ $event->body }}
                    </p>
                    @auth
                        @if(auth()->user()->id == $event->user_id )
                            @can('event-delete')
                                <p>
                                    <a href="{{ url("/events/delete/$event->id") }}"
                                       class="btn btn-warning">
                                        {{ __('messages.Delete') }}
                                    </a>
                                </p>
                            @endcan
                        @endif
                        <p>
                            <a href="{{ url("/organizations/".$event->user->organization_id) }}" class="">
                                {{ __('messages.Organization')}}
                            </a>
                        </p>
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
                    @endauth
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
