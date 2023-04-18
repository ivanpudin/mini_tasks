<?php
use GuzzleHttp\Client;

class apiUnfinishedTasksTest extends \PHPUnit\Framework\TestCase

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

 public function testGetUser()
 {
  $firstname1 = 'test_user1_firstname';
  $lastname1 = 'test_user1_lastname';
  $email1 = 'test_user1@email.com';
  $password1 = 'password1';
  $firstname2 = 'test_user2_firstname';
  $lastname2 = 'test_user2_lastname';
  $email2 = 'test_user2@email.com';
  $password2 = 'password2';
  $task1Title = 'task1 title';
  $task1Description = 'task1 description';
  $task1CreatedAt = '2023-04-15 15:00:00';
  $task1Deadline = '2023-04-20';
  $task1Performer = '1';
  $task2Title = 'task2 title';
  $task2Description = 'task2 description';
  $task2CreatedAt = '2023-04-20 15:00:00';
  $task2Deadline = '2023-05-10';
  $task2Performer = '2';

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_tasks');

  $this->assertEquals(204, $response->getStatusCode());

  $this->__connection->exec("INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`) VALUES
        ('$firstname1', '$lastname1', '$email1', '$password1');
        ");
  $this->__connection->exec("INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`) VALUES
        ('$firstname2', '$lastname2', '$email2', '$password2');
        ");

  $this->__connection->exec("INSERT INTO `tasks` (`id`, `title`, `description`, `created_at`, `deadline`, `performer`, `status`, `comment`, `closing_date`) VALUES\n"

   . "(1, '$task1Title', '$task1Description', '$task1CreatedAt', '$task1Deadline', $task1Performer, 0, NULL, NULL),\n"

   . "(2, '$task2Title', '$task2Description', '$task2CreatedAt', '$task2Deadline', $task2Performer, 0, NULL, NULL);");

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_tasks');

  $this->assertEquals(200, $response->getStatusCode());
  $this->assertJsonStringEqualsJsonString(
   json_encode(
    [['id' => 1, 'title' => $task1Title, 'description' => $task1Description, 'created_at' => $task1CreatedAt, 'deadline' => $task1Deadline, 'firstname' => $firstname1, 'lastname' => $lastname1, 'status' => 0],
    ['id' => 2, 'title' => $task2Title, 'description' => $task2Description, 'created_at' => $task2CreatedAt, 'deadline' => $task2Deadline, 'firstname' => $firstname2, 'lastname' => $lastname2, 'status' => 0],
   ]),
   $response->getBody()->getContents()
  );

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_tasks&deadline=2023-04-30');

  $this->assertEquals(200, $response->getStatusCode());
  $this->assertJsonStringEqualsJsonString(
   json_encode(
    [['id' => 1, 'title' => $task1Title, 'description' => $task1Description, 'created_at' => $task1CreatedAt, 'deadline' => $task1Deadline, 'firstname' => $firstname1, 'lastname' => $lastname1, 'status' => 0]
   ]),
   $response->getBody()->getContents()
  );

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_tasks&user=1');

  $this->assertEquals(200, $response->getStatusCode());
  $this->assertJsonStringEqualsJsonString(
   json_encode(
    [['id' => 1, 'title' => $task1Title, 'description' => $task1Description, 'created_at' => $task1CreatedAt, 'deadline' => $task1Deadline, 'firstname' => $firstname1, 'lastname' => $lastname1, 'status' => 0]
   ]),
   $response->getBody()->getContents()
  );

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_tasks&user=2&deadline=2023-04-30');

  $this->assertEquals(204, $response->getStatusCode());

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_tasks&user=1&deadline=2023-04-30');

  $this->assertEquals(200, $response->getStatusCode());
  $this->assertJsonStringEqualsJsonString(
   json_encode(
    [['id' => 1, 'title' => $task1Title, 'description' => $task1Description, 'created_at' => $task1CreatedAt, 'deadline' => $task1Deadline, 'firstname' => $firstname1, 'lastname' => $lastname1, 'status' => 0]
   ]),
   $response->getBody()->getContents()
  );

  $response = $this->__client->get('http://localhost:7001/task3/apiTest.php?action=get_task&task=1');  
  $this->assertEquals(200, $response->getStatusCode());
  $this->assertJsonStringEqualsJsonString(
   json_encode(
    ['id' => 1, 'title' => $task1Title, 'description' => $task1Description, 'created_at' => $task1CreatedAt, 'deadline' => $task1Deadline, 'firstname' => $firstname1, 'lastname' => $lastname1, 'status' => 0]
   ),
   $response->getBody()->getContents()
  );
 }

 public function tearDown(): void
 {
  $this->__connection->exec("DROP DATABASE $this->__testdbname");
 }
}
