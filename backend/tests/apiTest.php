<?php 

use GuzzleHttp\Client;

class ApiTest extends \PHPUnit\Framework\TestCase
{
    private $client;
    private $conn;

    public function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:7001/task3/',
            'http_errors' => false,
        ]);


        $host = 'db';
        $user = 'root';
        $pass = 'lionPass';
        $dbname = 'ApiDB';

        $this->conn = new mysqli($host, $user, $pass, $dbname);
        if ($this->conn->connect_error) {
            die("<div style='margin-top: 15px;'>Connection failed: {$this->conn->connect_error}</div>");
        }
    }

    public function testGetUser()
    {
        // Создать тестового пользователя в базе данных
        $email = 'test@example.com';
        $password = 'password';
        $stmt = $this->conn->prepare("INSERT INTO `users` (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        // Отправить запрос к API для получения пользователя
        $response = $this->client->post('/api.php', [
            'json' => [
                'action' => 'get_user',
                'email' => $email,
                'password' => $password,
            ],
        ]);

        // Проверить, что ответ имеет код 200 и содержит ожидаемый JSON
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['email' => $email, 'password' => $password]),
            $response->getBody()->getContents()
        );
    }

    public function tearDown(): void
    {
        // Удалить тестового пользователя из базы данных
        $email = 'test@example.com';
        $stmt = $this->conn->prepare("DELETE FROM `users` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $this->conn->close();
    }
}