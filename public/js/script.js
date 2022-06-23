class Faced {
    constructor(age, gender,genderProbability,angry,disgusted,fearful,happy,neutral,sad,surprised) {
        this.age = age;
        this.gender = gender;
        this.genderProbability = genderProbability;
        this.angry = angry;
        this.disgusted = disgusted;
        this.fearful = fearful;
        this.happy = happy;
        this.neutral = neutral;
        this.sad = sad;
        this.surprised = surprised;
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
    console.log("hi");
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions().withAgeAndGender()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

      for (const resizedDetection of resizedDetections) {
          var n = 4;
          let angry = resizedDetection.expressions.angry.toFixed(n);
          let disgusted = resizedDetection.expressions.disgusted.toFixed(n);
          let fearful = resizedDetection.expressions.fearful.toFixed(n);
          let happy = resizedDetection.expressions.happy.toFixed(n);
          let neutral = resizedDetection.expressions.neutral.toFixed(n);
          let sad = resizedDetection.expressions.sad.toFixed(n);
          let surprised = resizedDetection.expressions.surprised.toFixed(n);
          let age = resizedDetection.age.toFixed(n);
          var gender = resizedDetection.gender;
          let genderProbability = resizedDetection.genderProbability.toFixed(n);

          let myFaced = new Faced(age,gender,genderProbability,angry,disgusted,fearful,happy,neutral,sad,surprised);
          listOfFaced.push(myFaced);
          console.log(myFaced)
          if(listOfFaced.length>=360){
              console.log(listOfFaced);
              listOfFaced = [];

          }



      }

    faceapi.draw.drawDetections(canvas, resizedDetections)
    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)


  }, 300)
})
