
const recordVoice = () => {
  const recordButton = document.getElementById('recording')

  navigator.mediaDevices.getUserMedia({ audio: true, video: false }).then(stream => {
    const mediaRecorder = new MediaRecorder(stream)
    mediaRecorder.start()
    recordButton.innerHTML = 'Aufzeichnung'

    const audioChunks = []

    mediaRecorder.addEventListener('dataavailable', event => {
      audioChunks.push(event.data)
    })

    mediaRecorder.addEventListener('stop', () => {
      const audioBlob = new Blob(audioChunks, { 'type' : 'audio/wav; codecs=MS_PCM' })
      let editBlob = audioBlob
      editBlob.lastModifiedDate = new Date()
      editBlob.name = 'recording'
      download(audioChunks, 'recording.wav', { 'type' : 'audio/wav; codecs=0' })
      const audioUrl = URL.createObjectURL(audioBlob)
      const audio = new Audio(audioUrl)
      audio.play()
    })

    setTimeout(() => {
      mediaRecorder.stop()
      recordButton.innerHTML = 'Aufnehmen'
    }, 3000);

  })
}

const download = (data, filename, type) => {
  var file = new Blob([data], {type: type});
  if (window.navigator.msSaveOrOpenBlob) // IE10+
      window.navigator.msSaveOrOpenBlob(file, filename);
  else { // Others
      var a = document.createElement("a"),
              url = URL.createObjectURL(file);
      a.href = url;
      a.download = filename;
      document.body.appendChild(a);
      a.click();
      setTimeout(function() {
          document.body.removeChild(a);
          window.URL.revokeObjectURL(url);  
      }, 0); 
  }
}

const sendSpeak = (message) => {
  let xhr = new XMLHttpRequest()

  xhr.open('POST', 'php/speak.php')
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById('recordings').appendChild(new DOMParser().parseFromString(xhr.responseText, 'text/html').documentElement)
      } else if (xhr.status === 400) {
        alert('There was an error 400')
      } else {
        alert('something else other than 200 was returned')
      }
    }
  }
  xhr.send(encodeURI('message="' + message + '"'))
}