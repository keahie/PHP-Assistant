<?php

class SqlConnection {

    function __construct()
    {
        $this->host_name = '34.65.49.141';
        $this->database = 'assistant';
        $this->user_name = 'root';
        $this->password = 'MtAgA87bdAgOjmA5';
    }

    function connect() {
        return new mysqli($this->host_name, $this->user_name, $this->password, $this->database);
    }
}
