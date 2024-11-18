<?php

$error = array_key_exists("error", $_GET) ?
  htmlspecialchars((string)$_GET["error"])
  : null;
$message = array_key_exists("message", $_GET) ?
  htmlspecialchars(urldecode(string: (string)$_GET["message"]))
  : null;

function error_form_script()
{
  global $error, $message;
  if ($error !== "script") return;
  echo "alert($message)";
}
