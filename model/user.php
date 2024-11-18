<?php

require_once __DIR__ . "/../util/bcrypt.php";
require_once __DIR__ . "/../config/env.php";
require_once __DIR__ . "/model.php";

class User extends Model
{
  const SQL = "CREATE TABLE IF NOT EXISTS users (
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
    $this->pdo->exec(self::SQL);
  }

  function getById(int $id)
  {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
      $stmt->bindParam(":id", $id);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute();
      $user = $stmt->fetch();
      $this->pdo->commit();
      return $user;
    } catch (Exception $e) {
      if (DEBUG) throw $e;
      $this->pdo->rollBack();
      return null;
    }
  }

  function getByEmail(string $email)
  {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
      $stmt->bindParam(":email", $email);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute();
      $user = $stmt->fetch();
      $this->pdo->commit();
      return $user;
    } catch (Exception $e) {
      if (DEBUG) throw $e;
      $this->pdo->rollBack();
      return null;
    }
  }

  function all()
  {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM users");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $users = $stmt->fetchAll();
      $this->pdo->commit();
      return $users;
    } catch (Exception $e) {
      if (DEBUG) throw $e;
      $this->pdo->rollBack();
    }
  }

  function create(string $username, string $email, string|null $password = null): bool
  {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("INSERT INTO users(username, email, password) VALUES (:username, :email, :password)");
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":email", $email);

      $hash = $password === null ? $password : bcrypt_hash($password);
      $stmt->bindParam(":password", $hash);

      $stmt->execute();
      $this->pdo->commit();
      return true;
    } catch (Exception $e) {
      if (DEBUG) throw $e;
      $this->pdo->rollBack();
      return false;
    }
  }

  function update(int $id, string $username, string $email, string|null $password = null)
  {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("UPDATE users SET username=:username, email=:email, password=:password SET id=:id");
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $password);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $this->pdo->commit();
    } catch (Exception $e) {
      if (DEBUG) throw $e;
      $this->pdo->rollBack();
    }
  }

  function destroy(int $id)
  {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=:id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $this->pdo->commit();
      return true;
    } catch (Exception $e) {
      if (DEBUG) throw $e;
      $this->pdo->rollBack();
      return false;
    }
  }
}
