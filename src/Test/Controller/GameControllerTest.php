<?php

use PHPUnit\Framework\TestCase;
use Goutte\Client; // Crawler
// use GuzzleHttp\Client;

class GameControllerTest extends TestCase {

  // using guzzle and for testing
  public function testIndex_hasUl() {
    $client = new Client();
    $response = $client->request('GET', 'http://gamebook.test/web');
    $this->assertCount(6, $response->filter('ul > li')); // finds HTML (does not need regex)
    // $this->assertMatchesRegularExpression('/<ul>/', $response->getBody()->getContents());
  }

  public function testApiGames_WithUser_Returns6Items() {
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', 'http://gamebook.test/web/api-games.php', ['json' => [ 'user' => '1']]);
    // json formatting
    $json = $response->getBody()->getContents();
    // json comparison
    $this->assertJsonStringEqualsJsonString(file_get_contents(__DIR__.'/api-games-user.json'), $json);
  }

  public function testAddRating_WithGet_HasEmptyForm() {
    $client = new Client();
    // check if form exists
    $response = $client->request('GET', 'http://gamebook.test/web/add-rating.php?game=1');
    $this->assertCount(1, $response->filter('form'));
    $this->assertEquals('', $response->filter('form input[name=score]')->attr('value'));
  }

  public function testAddRating_WithPost_IsRedirect() {
    // make sure that saved into DB and redirected
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'http://gamebook.test/web/add-rating.php?game=1', [
      'allow_redirects' => false,
      'multipart' => [
        [
          'name' => 'score',
          'contents' => '5'
        ],
        [
          'name' => 'screenshot',
          'contents' => fopen(__DIR__. '/screenshot.jpg', 'r')
        ]
      ]
    ]);
    $this->assertEquals(302, $response->getStatusCode()); // 302 = redirect
    $this->assertEquals('/web', $response->getHeaderLine('Location')); // evaluating header

    // checking data
    $pdo = new PDO('mysql:host=localhost;dbname=gamebook_test', 'root', 'administrator');
    $statement = $pdo->prepare('SELECT * FROM rating');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC); // avoiding duplicates

    // asserts
    $this->assertCount(1, $result);
    $this->assertEquals(['user_id' => '1', 'game_id' => '1', 'score' => '5'], $result[0]);

    // file moved
    $this->assertFileExists(__DIR__.'/../../../web/screenshots/1-1.jpg');
  }

}


?>
