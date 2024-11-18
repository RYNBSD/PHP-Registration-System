<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/env.php";
require_once __DIR__ . "/../util/cipher.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/fn.php";

const AUTH_COOKIE_USER_ID = "user-id";

function auth()
{
  $encrypted_user_id = (string)safe_array_access(AUTH_COOKIE_USER_ID, $_COOKIE);
  if (strlen($encrypted_user_id) === 0) return null;

  $user_id = (int)decipher($encrypted_user_id);
  $user = new User();
  return $user->getById($user_id);
}

function is_auth()
{
  $user = auth();
  return isset($user);
}

function auth_remember(int $id, bool $remember)
{
  $safe_cookie = DEBUG ? false : true;
  $encrypted_value = cipher((string)$id);
  setcookie(AUTH_COOKIE_USER_ID, $encrypted_value, $remember ? 60 * 60 * 24 * 30 : 0, "/", "", $safe_cookie, $safe_cookie);
}

function auth_forget()
{
  unset($_COOKIE[AUTH_COOKIE_USER_ID]);
  setcookie(AUTH_COOKIE_USER_ID, "", -1, "/");
}
