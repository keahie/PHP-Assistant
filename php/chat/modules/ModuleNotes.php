<?php
require_once('modules/SqlConnection.php');
require_once('utils/AssistantUtils.php');
require_once('utils/DateUtils.php');
require_once('chat/Module.php');

class ModuleNotes extends Module
{
    function __construct()
    {
        $trigger = array(array('erinner', 'mich'));
        parent::__construct($trigger);
    }

    function getResponse($input)
    {
        global $months;
        $sql_connection = new SqlConnection();
        $database_connection = $sql_connection->connect();

        $note_text = '';
        $note_date = '';
        $note_time = '';

        $save_text = false;
        $save_date = false;
        $save_time = false;

        $key_words = array('am', 'um', 'daran', 'an', 'ein', 'einen');

        foreach ($input as $element) {
            if (!in_array($element, $key_words)) {
                if ($save_date) {
                    $note_date .= $element . ' ';
                } elseif ($save_time) {
                    $note_time .= $element . ' ';
                } elseif ($save_text) {
                    $note_text .= $element . ' ';
                }
            }
            if ($element === 'am') {
                $save_date = true;
            } elseif ($element === 'um') {
                $save_time = true;
                $save_date = false;
            } elseif ($element === 'daran' || $element === 'an' || $element === 'ein' || $element === 'einen') {
                $save_text = true;
                $save_date = false;
                $save_time = false;
            }
        }
        $note_text = substr($note_text, 0, strlen($note_text) - 1);
        $note_date = substr($note_date, 0, strlen($note_date) - 1);
        $note_time = substr($note_time, 0, strlen($note_time) - 1);

        $sql_date = explode(' ', $note_date);
        $sql_date[0] = str_replace('.', '', $sql_date[0]);
        $sql_date[1] = array_search(explode(' ', $note_date)[1], $months);
        if (sizeof($sql_date) === 2) {
            array_push($sql_date, date('Y'));
        }
        $sql_date = implode('-', $sql_date);

        $sql_text = str_replace('zu ', '', $note_text);
        $sql_text = str_replace('zu', '', $note_text);

        try {
            if ($note_time) {
                $sql_time = (sizeof(explode(' ', $note_time)) === 3 ? str_replace(' uhr ', ':', $note_time) : str_replace(' uhr', ':00', $note_time)) . ':00';
                $date = date('Y-m-d H:i:s', strtotime($sql_date . ' ' . $sql_time));
                $sql = 'INSERT INTO notes (text, reminder) VALUES("' . $sql_text . '", "' . $date . '");';
                if ($database_connection->query($sql)) {
                    return 'Ok. Ich errinere Sie am ' . $note_date . ' um ' . $note_time . ' daran, ' . $note_text;
                }
            } else {
                $sql = 'INSERT INTO notes (text, reminder) VALUES("' . $sql_text . '", "' . date('Y-m-d H:i:s', strtotime($sql_date)) . '");';
                if ($database_connection->query($sql)) {
                    return 'Ok. Ich errinere Sie am ' . $note_date . ' daran, ' . $note_text;
                }
            }
        } catch (\Throwable $th) {

        }
        

        return "Tut mir leid. Das ist etwas schief gelaufen. Bitte versuchen Sie es erneut!";
    }
}