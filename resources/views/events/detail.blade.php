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
                    <a href="{{ url("/events/delete/$event->id") }}"
                        class="btn btn-warning">
                        Delete
                    </a>
                </div>
            </div>

            <ul class="list-group">
                <li class="list-group-item active">
                   <b>Comments ({{ count($event->comments) }})</b>
                </li>
                @foreach ($event->comments as $comment)
                    <li class="list-group-item">
                        <a href="{{ url("/comments/delete/$comment->id") }}"
                            class="btn-close float-end">
                        </a>
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
                    <textarea name="content" class="form-control mb-2" placeholder="New Event Comment"></textarea>

                    <input type="submit" value="Add Event Comment" class="btn btn-secondary">
                </form>
            @endauth
        </div>
    @endsection
</body>
</html>
