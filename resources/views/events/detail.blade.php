<!DOCTYPE html>
<script>
    const EventId = "{{$event->id}}";
    const SessionID = "<?php echo time(); ?>";
</script>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail</title>
    <script defer src="{{url("js/face-api.min.js")}}"></script>
    <script defer src="{{url("js/script.js")}}"></script>
</head>
<body>


    @extends('layouts.app')

    @section('content')
            <div style="margin-bottom: 3%">
                <div class="row">
                    <div class="col-md-12">
                        <video id="video" width="1.30" height="1.01" autoplay muted></video>
                    </div>
                </div>
            </div>
            <div class="ratio ratio-16x9" >
                <div  id="player"></div>
            </div>
            <div class="card mb-2">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">
                             <h5 class="card-title">{{ $event->title }}</h5>
                        </div>
                    </div>
                    @if(auth()->user()->id == $event->user_id)
                        <div class="row">
                            <div class="col-md-8">
                                <a href="{{url("events/statistics")}}/{{$event->id}}"><h5 class="card-title">Статистика</h5></a>
                            </div>
                        </div>
                    @endif
                    <form action="{{ url('/events/event-like') }}" method="post">
                        @csrf
                        <input type="hidden" name="event_id"
                               value="{{ $event->id }}">
                        <p class="card-img-bottom">
                            <button  type="submit" class="btn btn-block btn-primary float-right"><i class="fa fa-thumbs-up">Like {{ $event->likes_count }}</i> </button>
                        </p>
                    </form>
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
    @endsection
</body>
</html>

<script>
    // Load the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // Replace the 'ytplayer' element with an <iframe> and
    // YouTube player after the API code downloads.
    var player;
    function onYouTubePlayerAPIReady() {
        player = new YT.Player('player', {
            playerVars: {
                rel:0,
                enablejsapi:0,
                modestbranding: 1, showinfo: 0, ecver: 0

            },

            videoId: '{{ $event->link }}',

        });
        player.modestbranding = 1;
        console.log(player);
    }

</script>
