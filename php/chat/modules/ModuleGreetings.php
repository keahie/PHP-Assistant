<?php
require_once('utils/AssistantUtils.php');
require_once('chat/Module.php');

class ModuleGreetings extends Module
{
    function __construct()
    {
        $trigger = array(array('hallo'), array('hi'), array('hey'), array('was', 'geht', 'so'));
        parent::__construct($trigger);
    }
    
    function getResponse($input)
    {
        return 'Hallo. Wie kann ich helfen?';
    }
} 