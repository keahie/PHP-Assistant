<?php
require_once('utils/AssistantUtils.php');
require_once('chat/Module.php');

class ModuleGoogleWeather extends Module
{
    function __construct()
    {
        $trigger = array(array('frag', 'google', 'wetter', 'wien'));
        parent::__construct($trigger);
    }

    function getResponse($input)
    {
        return 'Ok Google. Wie ist das Wetter in Wien.';   
    }
} 