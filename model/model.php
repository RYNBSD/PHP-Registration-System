<?php

declare(strict_types=1);

require_once __DIR__ . "/db.php";
require_once __DIR__ . "/../config/env.php";

class Model
{
  protected readonly PDO $pdo;

  function __construct()
  {
    $this->pdo = db_connect();
  }

  protected function transaction(string|Closure $callback, string|Closure|null $on_error = null)
  {
    $this->pdo->beginTransaction();
    try {
      $result = $callback();
      $this->pdo->commit();
      return $result;
    } catch (Exception $e) {
      $this->pdo->rollBack();
      if ($on_error !== null) return $on_error($e);
    }
    return null;
  }

  function __destruct()
  {
    db_close($this->pdo);
  }
}
