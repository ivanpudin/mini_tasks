<?php
use GuzzleHttp\Client;

class apiCreateUserTest extends \PHPUnit\Framework\TestCase

{
 private $__client;

 private $__connection;

 private $__host = 'localhost:7005';
 private $__user = 'root';
 private $__pass = 'lionPass';
 private $__testdbname = 'ApiDBTest';

 public function setUp(): void
 {

  $this->__connection = new PDO("mysql:host=$this->__host", $this->__user, $this->__pass);
  $this->__connection->exec("DROP DATABASE IF EXISTS $this->__testdbname;");
  $this->__connection->exec("CREATE DATABASE IF NOT EXISTS `$this->__testdbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci");
  $this->__connection->exec("USE `$this->__testdbname`");
  $this->__connection->exec("CREATE TABLE IF NOT EXISTS `tasks` (
            `id` int NOT NULL AUTO_INCREMENT,
            `title` varchar(100) NOT NULL,
            `description` text NOT NULL,
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `deadline` date NOT NULL,
            `performer` int NOT NULL,
            `status` tinyint(1) NOT NULL DEFAULT '0',
            `comment` varchar(1000) DEFAULT NULL,
            `closing_date` date DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");
  $this->__connection->exec("CREATE TABLE IF NOT EXISTS `users` (
            `id` int NOT NULL AUTO_INCREMENT,
            `firstname` varchar(20) NOT NULL,
            `lastname` varchar(30) NOT NULL,
            `email` varchar(30) NOT NULL,
            `password` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            ");
  $this->__connection->exec("ALTER TABLE `tasks` ADD FOREIGN KEY (`performer`) REFERENCES `users`(`id`);");

  $this->__client = new Client();
 }

 public function testCreateUser()
 {
  $firstname1 = 'test_user1_firstname';
  $lastname1 = 'test_user1_lastname';
  $email1 = 'test_user1@email.com';
  $password1 = 'password1';

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_users');
  $this->assertEquals(204, $response->getStatusCode());

  $response = $this->__client->post('http://localhost:7001/task3/apiTest.php', [
   'json' => [
    'action' => 'create_user',
    'firstname' => $firstname1,
    'lastname' => $lastname1,
    'email' => $email1,
    'password' => $password1,
   ],
  ]);
  $this->assertEquals(201, $response->getStatusCode());
  $this->assertJsonStringEqualsJsonString(
   json_encode(
    ['message' => 'User has been created successfully.']),
   $response->getBody()->getContents()
  );
 }

 public function tearDown(): void
 {
  $this->__connection->exec("DROP DATABASE $this->__testdbname");
 }
}
