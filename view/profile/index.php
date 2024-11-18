<?php
require_once __DIR__ . "/../../util/auth.php";
require_once __DIR__ . "/../../util/fn.php";

if (!is_auth()) {
  redirect("/view/register/sign-in/index.php");
}

print_r(auth());
