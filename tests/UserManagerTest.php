<?php

require_once __DIR__ . '/../src/models/UserManager.php';

use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase
{
  private $userManager;

  protected function setUp(): void
  {
    $this->userManager = new UserManager();
    $this->truncateUsersTable();
  }

  private function truncateUsersTable(): void
  {
    $stmt = $this->userManager->getDB()->prepare("TRUNCATE TABLE users");
    $stmt->execute();
  }

  public function testAddUser()
  {
    $this->userManager->addUser('John Doe', 'john.doe@example.com');

    $users = $this->userManager->getUsers();
    $this->assertCount(1, $users);
    $this->assertEquals('John Doe', $users[0]['name']);
    $this->assertEquals('john.doe@example.com', $users[0]['email']);
  }

  public function testAddUserEmailException()
  {
    $this->expectException(InvalidArgumentException::class);

    $this->userManager->addUser('Jane Doe', 'invalid-email');
  }

  public function testUpdateUser()
  {
    $this->userManager->addUser('John Doe', 'john.doe@example.com');
    $users = $this->userManager->getUsers();
    $user = $users[0];

    $this->userManager->updateUser($user['id'], 'Johnathan Doe', 'johnathan.doe@example.com');

    $updatedUser = $this->userManager->getUser($user['id']);
    $this->assertEquals('Johnathan Doe', $updatedUser['name']);
    $this->assertEquals('johnathan.doe@example.com', $updatedUser['email']);
  }

  public function testRemoveUser()
  {
    $this->userManager->addUser('John Doe', 'john.doe@example.com');
    $users = $this->userManager->getUsers();
    $user = $users[0];

    $this->userManager->removeUser($user['id']);
    $this->expectException(Exception::class);
    $this->userManager->getUser($user['id']);
  }

  public function testGetUsers()
  {
    $this->userManager->addUser('John Doe', 'john.doe@example.com');
    $this->userManager->addUser('Jane Doe', 'jane.doe@example.com');

    $users = $this->userManager->getUsers();
    $this->assertCount(2, $users);
  }

  public function testInvalidUpdateThrowsException()
  {
    $this->expectException(Exception::class);

    $this->userManager->updateUser(999, 'Non Existent', 'non.existent@example.com');
  }

  public function testInvalidDeleteThrowsException()
  {
    $this->expectException(Exception::class);

    $this->userManager->removeUser(999); // ID inexistant
  }
}
