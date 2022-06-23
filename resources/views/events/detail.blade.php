<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail</title>
    <script defer src="{{url("js/face-api.min.js")}}"></script>
    <script defer src="{{url("js/script.js")}}"></script>
</head>
<body>
<style>
    body {
        margin: 0;
        padding: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    canvas {
        position: absolute;
    }
</style>
{{--<div style="background-image: url('{{url("images/$event->photo")}}');" class="backroundDiv"></div>--}}

    @extends('layouts.app')

    @section('content')

        <div class="container">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-12">
                        <iframe id="player" width="1280" height="720"
                                src="https://www.youtube.com/embed/lEShIYsdrZ4"
                                title="Я не из тех, кто ксивой машет | ПрАкурор | 3 серия" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                        <video id="video" width="720" height="560" autoplay muted></video>
{{--
                        <video id="video" width="1.30" height="1.01" autoplay muted></video>
--}}

                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                             <h5 class="card-title">Я не из тех, кто ксивой машет | ПрАкурор | 3 серия</h5>
                        </div>
                    </div>

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

                    <input type="submit" value="{{ __('messages.addComent') }}" class="btn btn-secondary">
                </form>
            @endauth
        </div>
    @endsection
</body>
</html>
