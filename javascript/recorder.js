let SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition
let recognition = new SpeechRecognition()
recognition.lang = 'de'
recognition.continuous = false

let recordButton = document.getElementById('recording')

recognition.onresult = (event) => {
    var current = event.resultIndex
    var transcript = event.results[current][0].transcript

    var mobileRepeatBug = (current == 1 && transcript == event.results[0][0].transcript)

    if (!mobileRepeatBug) {
        sendSpeak(transcript)
        console.log(transcript)
    }
}

recognition.onstart = () => {
    recordButton.innerHTML = 'Aufzeichnung'
}

recognition.onspeechend = () => {
    recordButton.innerHTML = 'Aufzeichnen'
}

recognition.onerror = (event) => {
    if (event.error = 'no-speech') {
        console.error('[RECORDER] No speech detectet. Try again')
    } else {
        console.error('[RECORDER] error', event.error)
    }
}