<?php

declare(strict_types=1);

require_once __DIR__ . "/dotenv.php";

function redirect(string $path, array $params = [])
{
  $uri = APP_URL . $path . "?";
  $params_length = count($params);

  foreach ($params as $k => $v) {
    $uri .= $k . "=" . urlencode((string)$v);
    if (--$params_length > 0) $uri .= "&";
  }

  header("Location: " . $uri);
  die();
}

function safe_array_access(int|string $key, array|ArrayObject $arr)
{
  return array_key_exists($key, $arr) ? $arr[$key] : null;
}
