<?php

require_once __DIR__ . "/db.php";
require_once __DIR__ . "/../config/env.php";

class Model
{
  protected readonly PDO $pdo;

  function __construct()
  {
    $this->pdo = db_connect();
  }

  function __destruct()
  {
    db_close($this->pdo);
  }
}
