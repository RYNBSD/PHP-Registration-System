<?php

declare(strict_types=1);

function bcrypt_hash(string $str)
{
  $trimmed = trim($str);
  if (strlen($trimmed) === 0) throw new UnexpectedValueException("Empty string provided");
  return password_hash($str, PASSWORD_BCRYPT);
}

function bcrypt_compare(string $password, string $hash)
{
  $trimmed_password = trim($password);
  if (strlen($trimmed_password) === 0) throw new UnexpectedValueException("Empty password provided");
  $trimmed_hash = trim($hash);
  if (strlen($trimmed_hash) === 0) throw new UnexpectedValueException("Empty hash provided");
  return password_verify($password, $hash);
}
