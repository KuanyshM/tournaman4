<!DOCTYPE html>
<html>
<head>
    <script src="{{url("presentation/face-api.js")}}"></script>
    <script src="{{url("presentation/js/commons.js")}}"></script>
    <script src="{{url("presentation/js/faceDetectionControls.js")}}"></script>
    <link rel="stylesheet" href="{{url("presentation/styles.css")}}">
    <link rel="stylesheet" href="{{url("presentation/js/materialize.css")}}">
    <script type="text/javascript" src="{{url("presentation/js/jquery-2.1.1.min.js")}}"></script>
    <script src="{{url("presentation/js/materialize.min.js")}}"></script>
</head>
<body>
<div id="navbar"></div>
<div class="center-content page-container">

    <div style="position: relative" class="margin">
        <video onloadedmetadata="onPlay(this)" id="inputVideo" autoplay muted playsinline></video>
        <canvas id="overlay" />
    </div>





</body>

<script>
    let forwardTimes = []
    let withBoxes = true


    function updateTimeStats(timeInMs) {
        forwardTimes = [timeInMs].concat(forwardTimes).slice(0, 30)
        const avgTimeInMs = forwardTimes.reduce((total, t) => total + t) / forwardTimes.length
        $('#time').val(`${Math.round(avgTimeInMs)} ms`)
        $('#fps').val(`${faceapi.utils.round(1000 / avgTimeInMs)}`)
    }

    async function onPlay() {
        const videoEl = $('#inputVideo').get(0)

        if(videoEl.paused || videoEl.ended || !isFaceDetectionModelLoaded())
            return setTimeout(() => onPlay())


        const options = getFaceDetectorOptions()

        const ts = Date.now()

        const result = await faceapi.detectSingleFace(videoEl, options).withFaceLandmarks()


        if (result) {
            const canvas = $('#overlay').get(0)
            const dims = faceapi.matchDimensions(canvas, videoEl, true)
            const resizedResult = faceapi.resizeResults(result, dims)

            if (withBoxes) {
                faceapi.draw.drawDetections(canvas, resizedResult)
            }
            faceapi.draw.drawFaceLandmarks(canvas, resizedResult)

        }

        setTimeout(() => onPlay())
    }

    async function run() {
        // load face detection and face landmark models
        await changeFaceDetector(TINY_FACE_DETECTOR)
        await faceapi.loadFaceLandmarkModel('/')
        changeInputSize(224)

        // try to access users webcam and stream the images
        // to the video element
        const stream = await navigator.mediaDevices.getUserMedia({ video: {} })
        const videoEl = $('#inputVideo').get(0)
        videoEl.srcObject = stream
    }

    function updateResults() {}

    $(document).ready(function() {
        renderNavBar('#navbar', 'webcam_face_landmark_detection')
        initFaceDetectionControls()
        run()
    })
</script>
</body>
</html>
