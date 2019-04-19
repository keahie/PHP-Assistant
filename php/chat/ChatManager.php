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
                if (is_array($element)) {
                    $containsAllWords = true;
                    foreach ($element as $string) {
                        if (!str_contains($string, $input))
                        {
                            $containsAllWords = false;
                            break;
                        }
                    }
                    if ($containsAllWords)
                    {
                        $input = explode(' ', $input);
                        return $module->getResponse($input);
                    }
                }
            }
        }
        return 'Tut mir leid. Das habe ich leider nicht verstanden.';
    }

    function init() {
        foreach (scandir(dirname('chat/modules/modules')) as $filename) {
            $path = dirname('chat/modules/modules') . '/' . $filename;
            if (is_file($path)) {
                require $path;
                $className = preg_replace("/[^a-zA-Z]/", "", basename($path, '.php').PHP_EOL);
                array_push($this->modules, new $className());
            }
        }
    }
}
