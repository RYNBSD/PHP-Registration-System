<?php

require_once __DIR__ . "/../util/fn.php";

$error =
  htmlspecialchars((string)safe_array_access("error", $_GET));

$message =
  htmlspecialchars(urldecode((string)safe_array_access("message", $_GET)));

function error_form_script()
{
  global $error, $message;
  if ($error !== "script") return;
  echo "alert($message)";
}
