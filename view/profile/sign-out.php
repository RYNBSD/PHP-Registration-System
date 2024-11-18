<?php

require_once __DIR__ . "/../../util/fn.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  redirect("/view/profile/index.php");
}

require_once __DIR__ . "/../../util/auth.php";

if (!is_auth()) {
  redirect("/view/register/sign-in/index.php");
}

auth_forget();
redirect("/view/register/sign-in/index.php");
