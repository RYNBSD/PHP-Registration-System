<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  redirect("/view/register/sign-in/index.php");
}

require_once __DIR__ . "/../../../model/user.php";
require_once __DIR__ . "/../../../config/env.php";
require_once __DIR__ . "/../../../util/sanitizer.php";
require_once __DIR__ . "/../../../util/fn.php";
require_once __DIR__ . "/../../../util/bcrypt.php";
require_once __DIR__ . "/../../../util/auth.php";

$remember = (bool)safe_array_access("remember", $_POST);
$email = sanitize_str((string)safe_array_access("email", $_POST));
if (strlen($email) === 0) {
  redirect("/view/register/sign-in/index.php", [
    "error" => "email",
    "message" => "Invalid email",
    "email" => $email,
    "remember" => $remember,
  ]);
}

$user = new User();
$check_email = $user->getByEmail($email);

if (!$check_email || !isset($check_email)) {
  redirect("/view/register/sign-in/index.php", [
    "error" => "email",
    "message" => "User not found",
    "email" => $email,
    "remember" => $remember,
  ]);
}

$password = sanitize_str((string)safe_array_access("password", $_POST));

if (strlen($password) === 0) {
  redirect("/view/register/sign-in/index.php", [
    "error" => "password",
    "message" => "Invalid password",
    "email" => $email,
    "remember" => $remember
  ]);
}

if (bcrypt_compare($password, $check_email["password"])) {
  redirect("/view/register/sign-in/index.php", [
    "error" => "password",
    "message" => "Invalid password",
    "email" => $email,
    "remember" => $remember
  ]);
}

auth_remember($check_email["id"], $remember);

redirect("/view/profile/index.php");
