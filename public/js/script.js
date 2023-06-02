class Faced {
    constructor(age, gender,genderProbability,angry,disgusted,fearful,happy,neutral,sad,surprised,state,currentTime) {
        this.a = age;
        this.g = gender;
        this.gp = genderProbability;
        this.an = angry;
        this.d = disgusted;
        this.f = fearful;
        this.h = happy;
        this.n = neutral;
        this.s = sad;
        this.su = surprised;
        this.st = state;
        this.ct = currentTime
    }
    optimize(){
        if(this.a<0.0003){
            delete this.a;
        }
        if(this.an<0.0003){
            delete this.an;
        }
        if(this.d<0.0003){
            delete this.d;
        }
        if(this.f<0.0003){
            delete this.f;
        }
        if(this.h<0.0003){
            delete this.h;
        }
        if(this.n<0.0003){
            delete this.n;
        }
        if(this.s<0.0003){
            delete this.s;
        }
        if(this.su<0.0003){
            delete this.su;
        }


    }
}
var listOfFaced = [];


const video = document.getElementById('video')

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
  faceapi.nets.faceExpressionNet.loadFromUri('/models'),
    faceapi.nets.ageGenderNet.loadFromUri('/models')
]).then(startVideo)

function startVideo() {
  navigator.getUserMedia(
    { video: {} },
    stream => video.srcObject = stream,
    err => console.error(err)
  )
}

video.addEventListener('play', () => {
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)
  const displaySize = { width: video.width, height: video.height }
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions().withAgeAndGender()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

      for (const resizedDetection of resizedDetections) {
          var n = 4;
          let angry =  parseFloat(resizedDetection.expressions.angry.toFixed(n));
          let disgusted = parseFloat(resizedDetection.expressions.disgusted.toFixed(n));
          let fearful = parseFloat(resizedDetection.expressions.fearful.toFixed(n));
          let happy = parseFloat(resizedDetection.expressions.happy.toFixed(n));
          let neutral = parseFloat(resizedDetection.expressions.neutral.toFixed(n));
          let sad = parseFloat(resizedDetection.expressions.sad.toFixed(n));
          let surprised = parseFloat(resizedDetection.expressions.surprised.toFixed(n));
          let age = parseFloat(resizedDetection.age.toFixed(1));
          let genderProbability = parseFloat(resizedDetection.genderProbability.toFixed(n));
          if(resizedDetection.gender=="male"){
              var gender = 1;
          }else{
              var gender = 2;
          }
          let state = player.getPlayerState();
          let currentTime = parseFloat(player.getCurrentTime().toFixed(2));



          if(player.getPlayerState() && (player.getPlayerState()==1 || player.getPlayerState()==3)){
              let myFaced = new Faced(age,gender,genderProbability,angry,disgusted,fearful,happy,neutral,sad,surprised,state,currentTime);
              myFaced.optimize();
              listOfFaced.push(myFaced);
             // console.log(myFaced)
          }
          if(listOfFaced.length>=10){
              var myHeaders = new Headers();
              myHeaders.append("Content-Type", "application/json");

              var raw = JSON.stringify({
                  "Tracktions": listOfFaced
              });

              var requestOptions = {
                  method: 'POST',
                  headers: myHeaders,
                  body: raw,
                  redirect: 'follow'
              };
              var baseUrl = window.location.origin;
              fetch(baseUrl+"/api/track", requestOptions)

                  .catch(error => console.log('error', error));
             // console.log(listOfFaced);
              listOfFaced = [];


          }



      }

    faceapi.draw.drawDetections(canvas, resizedDetections)
    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)


  }, 300)
});

