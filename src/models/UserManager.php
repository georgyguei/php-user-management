<?php

class UserManager
{
  private $_db;

  public function addUser(string $name, string $email): void
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \InvalidArgumentException("Invalid email.", 400);
    }
    $stmt = $this->getDB()->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->execute(['name' => $name, 'email' => $email]);
  }

  public function removeUser(int $id): void
  {
    $stmt = $this->getDB()->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
      throw new \Exception("User not found.", 404);
    }
  }

  public function getUsers(): array
  {
    $stmt = $this->getDB()->query("SELECT * FROM users");
    return $stmt->fetchAll();
  }

  public function getUser(int $id): array
  {
    $stmt = $this->getDB()->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
    if (!$user) {
      throw new \Exception("User not found.", 404);
    }
    return $user;
  }

  public function updateUser(int $id, string $name, string $email): void
  {
    $stmt = $this->getDB()->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
    $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);

    if ($stmt->rowCount() === 0) {
      throw new \Exception("User not found or no changes made.", 404);
    }
  }

  public function setDB()
  {
    try {
      $hostname = "db"; // - // Use this hostname for the docker container
      $hostname = "127.0.0.1"; // Use this hostname for the unit tests
      $base = 'user_management';
      $loginDB = "root";
      $passDB = "root";

      $dsn = "mysql:host={$hostname};dbname={$base};charset=utf8";

      $this->_db = new \PDO($dsn, $loginDB, $passDB, [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
      ]);
    } catch (\PDOException $e) {
      throw new \Exception("Database Connection failed: " . $e->getMessage(), 500);
    }
  }

  public function getDB()
  {
    if (!isset($this->_db)) {
      $this->setDB();
    }
    return $this->_db;
  }
}