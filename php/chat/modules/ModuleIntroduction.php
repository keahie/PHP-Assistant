<?php
require_once('utils/AssistantUtils.php');
require_once('chat/Module.php');

class ModuleIntroduction extends Module
{
    function __construct()
    {
        $trigger = array(array('erzähl', 'sag'), array('du'), array('bist'));
        parent::__construct($trigger);
    }

    function getResponse($input)
    {
        global $assistantName;
        return 'Hallo ' . $input[1] . '! Ich bin ' .  $assistantName . ', die persönliche Assistentin von Keanu Hie.';   
    }
} 