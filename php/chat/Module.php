<?php

abstract class Module
{
    public $input;
    public $trigger;
    public $response;

    function __construct($trigger)
    {
        $this->input = '';
        $this->trigger = $trigger;
        $this->response = 'Ein Modul hat keine Ausgabe!';
    }

    public abstract function getResponse($input);
}