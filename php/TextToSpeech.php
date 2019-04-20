<?php
require_once('modules/WavDuration.php');
require '../vendor/autoload.php';

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

class TextToSpeech
{

  private $client, $synthesisInputText, $voice, $audioConfig;

  function __construct()
  {
    
    $this->client = new TextToSpeechClient();
    $this->synthesisInputText = new SynthesisInput();
    $this->voice = (new VoiceSelectionParams())
      ->setLanguageCode('de-DE')
      ->setName('de-DE-Wavenet-C');

    $effectsProfileId = "telephony-class-application";
    $this->audioConfig = (new AudioConfig())
      ->setAudioEncoding(AudioEncoding::LINEAR16)
      ->setPitch(1.0)
      ->setSpeakingRate(1.0)
      ->setEffectsProfileId(array($effectsProfileId));
  }

  function translate($text)
  {
    $text = str_replace('Keanu', 'Keahnu', $text);
    $response = $this->client->synthesizeSpeech($this->synthesisInputText->setText($text), $this->voice, $this->audioConfig);
    $audioContent = $response->getAudioContent();

    file_put_contents('../sounds/output.wav', $audioContent);
    echo '<embed src="sounds/output.wav" hidden="true" autostart="true"></embed>';
  }
}
