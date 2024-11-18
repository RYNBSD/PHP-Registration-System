<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  redirect("/view/register/sign-up/index.php");
}

require_once __DIR__ . "/../../../util/sanitizer.php";
require_once __DIR__ . "/../../../util/fn.php";
require_once __DIR__ . "/../../../model/user.php";

$username = sanitize_str((string)safe_array_access("username", $_POST));
if (strlen($username) === 0) {
  redirect("/view/register/sign-up/index.php", ["error" => "username", "message" => "Invalid username"]);
}

$email = sanitize_str((string)safe_array_access("email", $_POST));
if (strlen($email) === 0) {
  redirect("/view/register/sign-up/index.php", ["error" => "email", "message" => "Invalid email"]);
}

$user = new User();
$check_email = $user->getByEmail($email);
if (isset($check_email) && $check_email) {
  redirect("/view/register/sign-up/index.php", ["error" => "email", "message" => "Email already exists"]);
}

$password = sanitize_str((string)safe_array_access("password", $_POST));

$ok = $user->create($username, $email, strlen($password) === 0 ? null : $password);
if (!$ok) {
  redirect("/view/register/sign-up/index.php", ["error" => "script", "message" => "Can\'t create new user"]);
}

redirect("/view/register/sign-in/index.php");
