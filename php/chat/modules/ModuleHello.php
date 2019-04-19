<?php
require_once('utils/AssistantUtils.php');
require_once('chat/Module.php');

class ModuleHello extends Module
{
    function __construct()
    {
        $trigger = array(array('wer bist du'), array('wie', 'heisst'), array('dein', 'name'), array('nennt', 'dich'));
        parent::__construct($trigger);
    }

    function getResponse($input)
    {
        global $assistantName;
        return 'Ich heiße ' . $assistantName;
    }
} 