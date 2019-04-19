<?php
require_once('MessageHandler.php');
// echo phpinfo();
if (isset($_POST['message'])) {
  echo handle_message($_POST['message']);
} 