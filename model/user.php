<?php

require_once __DIR__ . "/../util/bcrypt.php";
require_once __DIR__ . "/../config/env.php";
require_once __DIR__ . "/model.php";

class User extends Model
{
  const TABLE = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    deleted_at TIMESTAMP NULL
  )";

  function __construct()
  {
    parent::__construct();
    $this->pdo->exec(self::TABLE);
  }

  function getById(int $id)
  {
    return $this->transaction(function () use ($id) {
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id=:id AND deleted_at IS NULL LIMIT 1");
      $stmt->bindParam(":id", $id);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute();
      return $stmt->fetch();
    });
  }

  function getByEmail(string $email)
  {
    return $this->transaction(function () use ($email) {
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email AND deleted_at IS NULL LIMIT 1");
      $stmt->bindParam(":email", $email);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute();
      return $stmt->fetch();
    });
  }

  function all()
  {
    return $this->transaction(function () {
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE deleted_at IS NULL");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $users = $stmt->fetchAll();
      $this->pdo->commit();
      return $users;
    });
  }

  function create(string $username, string $email, string|null $password = null)
  {
    return $this->transaction(function () use ($username, $email, $password) {
      $stmt = $this->pdo->prepare("INSERT INTO users(username, email, password) VALUES (:username, :email, :password)");
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":email", $email);
      $hash = $password === null ? $password : bcrypt_hash($password);
      $stmt->bindParam(":password", $hash);
      $stmt->execute();
      $this->pdo->commit();
    });
  }

  function update(int $id, string $username, string $email, string|null $password = null)
  {
    return $this->transaction(function () use ($id, $username, $email, $password) {
      $stmt = $this->pdo->prepare("UPDATE users SET username=:username, email=:email, password=:password WHERE id=:id AND deleted_at IS NULL");
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $password);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
    });
  }

  function destroy(int $id)
  {
    return $this->transaction(function () use ($id) {
      $stmt = $this->pdo->prepare("UPDATE users SET deleted_at=CURRENT_TIMESTAMP() WHERE deleted_at IS NULL");
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $this->pdo->commit();
    });
  }
}
