<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  redirect("/view/register/sign-up/index.php");
}

require_once __DIR__ . "/../../../util/sanitizer.php";
require_once __DIR__ . "/../../../util/fn.php";
require_once __DIR__ . "/../../../model/user.php";

$username = sanitize_str((string)safe_array_access("username", $_POST));
$email = sanitize_str((string)safe_array_access("email", $_POST));

if (strlen($username) === 0) {
  redirect("/view/register/sign-up/index.php", [
    "error" => "username",
    "message" => "Invalid username",
    "username" => $username,
    "email" => $email
  ]);
}
if (strlen($email) === 0) {
  redirect("/view/register/sign-up/index.php", [
    "error" => "email",
    "message" => "Invalid email",
    "username" => $username,
    "email" => $email
  ]);
}

$user = new User();
$check_email = $user->getByEmail($email);
if (isset($check_email) && $check_email) {
  redirect("/view/register/sign-up/index.php", [
    "error" => "email",
    "message" => "Email already exists",
    "username" => $username,
    "email" => $email
  ]);
}

$password = sanitize_str((string)safe_array_access("password", $_POST));

$ok = $user->create($username, $email, strlen($password) === 0 ? null : $password);
if (!$ok) {
  redirect("/view/register/sign-up/index.php", [
    "error" => "script",
    "message" => "Can\'t create new user",
    "username" => $username,
    "email" => $email
  ]);
}

redirect("/view/register/sign-in/index.php");
