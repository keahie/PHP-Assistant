<?php
require_once('utils/StringUtils.php');

class ChatManager
{
    function __construct()
    {
        $this->modules = array();
        $this->init();
    }

    public function create_response($input)
    {
        foreach ($this->modules as $module) {
            foreach ($module->trigger as $element) {
                if ($this->validate_words($element, $input)) {
                    $validInput = explode(' ', $input);
                    return $module->getResponse($validInput);
                }
            }
        }
        return 'Tut mir leid. Das habe ich leider nicht verstanden.';
    }

    private function validate_words($array, $input)
    {
        $valid = true;
        foreach ($array as $element) {
            if (is_array($element)) {
                $valid = $this->validate_words($element, $input);
            } elseif (!str_contains($element, $input)) {
                $valid = false;
                break;
            }
        }
        return $valid;
    }

    function init()
    {
        foreach (scandir(dirname('chat/modules/modules')) as $filename) {
            $path = dirname('chat/modules/modules') . '/' . $filename;
            if (is_file($path)) {
                require $path;
                $className = preg_replace("/[^a-zA-Z]/", "", basename($path, '.php') . PHP_EOL);
                array_push($this->modules, new $className());
            }
        }
    }
}
