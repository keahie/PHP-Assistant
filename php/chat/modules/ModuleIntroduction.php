<?php
require_once('modules/SqlConnection.php');
require_once('utils/AssistantUtils.php');
require_once('chat/Module.php');

class ModuleIntroduction extends Module
{
    function __construct()
    {
        $trigger = array(array(array('stell'), array('dich'), array('vor')), array(array('erzähl', 'sag'), array('du'), array('bist')));
        parent::__construct($trigger);
    }

    function getResponse($input)
    {
        global $assistant_name;

        $names = array();

        $sql_connection = new SqlConnection();
        $database_connection = $sql_connection->connect();

        foreach ($input as $element) {
            $capitalized_element = ucfirst($element);
            $sql = 'SELECT name FROM names WHERE name="' . $capitalized_element . '";';
            $result = $database_connection->query($sql);

            if ($result->num_rows <= 0) {
                continue;
            }

            while ($row = $result->fetch_assoc()) {
                array_push($names, $row['name']);
            }
        }

        if (sizeof($names) !== 0) {
            $output = 'Hallo ';
            for ($i = 0; $i < sizeof($names); $i++) {
                if ($i === sizeof($names) - 2) {
                    if ($output[strlen($output) - 2] === ',') {
                        $output = substr($output, 0, strlen($output) - 2);
                        $output .= ', ' . $names[$i] . ' und ';
                    } else {
                        $output .= $names[$i] . ' und ';
                    }
                } elseif ($i === sizeof($names) - 1) {
                    $output .= $names[$i] . '. ';
                } else {
                    $output .= $names[$i] . ', ';
                }
            }
            $output .= 'Ich bin ' . $assistant_name . ', die persönliche Assistentin von Keanu Hie.';
            return $output;
        } else {
            return 'Hallo! Ich bin ' . $assistant_name . ', die persönliche Assistentin von Keanu Hie.';
        }

        return 'Tut mir leid. Das habe ich leider nicht verstanden';
    }
}
