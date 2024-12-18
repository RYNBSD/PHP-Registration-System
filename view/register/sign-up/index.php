<?php
require_once __DIR__ . "/../../../util/auth.php";
require_once __DIR__ . "/../../../util/fn.php";

if (is_auth()) {
  redirect("/view/profile/index.php");
}

require_once __DIR__ . "/../../../error/form.php";

$username = safe_array_access("username", $_GET) ?? "";
$email = safe_array_access("email", $_GET) ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
  <form method="post" action="./store.php">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input value="<?php echo htmlspecialchars($username); ?>" type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" required>
      <?php
      if ($error === "username") {
        echo "<div id=\"usernameHelp\" class=\"form-text\">$message</div>";
      }
      ?>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input value="<?php echo htmlspecialchars($email); ?>" type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
      <?php
      if ($error === "email") {
        echo "<div id=\"emailHelp\" class=\"form-text\">$message</div>";
      }
      ?>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" required>
      <?php
      if ($error === "password") {
        echo "<div id=\"passwordHelp\" class=\"form-text\">$message</div>";
      }
      ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>

<script>
  <?php
  error_form_script();
  ?>
</script>

</html>