<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/env.php";

function db_connect(): PDO
{
  $dsn = DB_TYPE . ":" . "host=" . DB_HOST . ";dbname=" . DB_NAME;
  $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $pdo;
}

function db_close(PDO &$pdo)
{
  $pdo = null;
}
