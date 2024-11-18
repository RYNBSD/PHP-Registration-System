<?php

declare(strict_types=1);

function sanitize_str(string $str): string
{
  $str = trim($str);
  $str = strip_tags($str);
  $str = addslashes($str);
  return $str;
}
