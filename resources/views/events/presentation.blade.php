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
    <script defer src="{{url("js/presentation.js")}}"></script>
</head>
<body>
    @extends('layouts.app')

    @section('content')
            <div style="margin-bottom: 3%">
                <div class="row">
                    <div id="div-presentation" class="col-md-12">
                        <video style="display: inline-block" id="video" width="640" height="480" autoplay muted></video>
                    </div>
                </div>
            </div>

    @endsection
</body>
</html>


