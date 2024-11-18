<?php
require_once __DIR__ . "/../../util/auth.php";
require_once __DIR__ . "/../../util/fn.php";

if (!is_auth()) {
  redirect("/view/register/sign-in/index.php");
}

print_r(auth());
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
</head>

<body>
  <form method="post" action="./sign-out.php">
    <button type="submit">Sign out</button>
  </form>
</body>

</html>