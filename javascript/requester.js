
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
      const audioBlob = new Blob(audioChunks)
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

const sendSpeak = () => {
  let xhr = new XMLHttpRequest()
  let message = document.getElementById('message').value

  console.log('message', message)

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