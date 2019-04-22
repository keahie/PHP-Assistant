<?php
require_once('TextToSpeech.php');
require_once('chat/ChatManager.php');
require_once('utils/StringUtils.php');
require_once('utils/AssistantUtils.php');
require_once('utils/DateUtils.php');

$textTranslator = new TextToSpeech();

function handle_message($message)
{
    global $textTranslator;

    $chatManager = new ChatManager();
    $message = str_validate($message);
    
    $textTranslator->translate($chatManager->create_response($message));
}
