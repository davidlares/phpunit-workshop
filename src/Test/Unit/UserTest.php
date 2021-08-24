<?php

use PHPUnit\Framework\TestCase;
// building tests from scratch with PHPUnit
require __DIR__ . "/../../Entity/Rating.php";
require __DIR__ . "/../../Entity/User.php";
require __DIR__ . "/../../Entity/Game.php";

// inherited PHPUnit
class UserTest extends TestCase {

  // test scenarios
  public function testGenreCompatibility_With8And6_Returns7() {
    //mocking score
    $rat1 = $this->getMockBuilder('Rating')->onlyMethods(['getScore'])->getMock();
    $rat1->method('getScore')->willReturn(6);
    $rat2 = $this->getMockBuilder('Rating')->onlyMethods(['getScore'])->getMock();
    $rat2->method('getScore')->willReturn(8);
    // mocking ratings
    $user = $this->getMockBuilder('User')->onlyMethods(['findRatingsByGenre'])->getMock();
    $user->method('findRatingsByGenre')->willReturn([$rat1, $rat2]);
    // getting average
    $this->assertEquals(7, $user->getGenreCompatibility('zombies'));
  }

  public function testRatingsByGenre_With1ZombieAnd1Shooter_Returns1Zombie() {
    //mocking score
    $zombies = $this->getMockBuilder('Game')->addMethods(['getGenreCode'])->getMock();
    $zombies->method('getGenreCode')->willReturn('zombies');
    $shooter = $this->getMockBuilder('Game')->addMethods(['getGenreCode'])->getMock();
    $shooter->method('getGenreCode')->willReturn('shooter');
    //mocking ratings
    $rat1 = $this->getMockBuilder('Rating')->onlyMethods(['getGame'])->getMock();
    $rat1->method('getGame')->willReturn($zombies);
    $rat2 = $this->getMockBuilder('Rating')->onlyMethods(['getGame'])->getMock();
    $rat2->method('getGame')->willReturn($shooter);
    // mocking user
    $user = $this->getMockBuilder('User')->onlyMethods(['getRatings'])->getMock();
    $user->method('getRatings')->willReturn([$rat1, $rat2]);

    // getting average
    $ratings = $user->findRatingsByGenre('zombies');
    $this->assertCount(1, $ratings);
    // iterating for zombies
    foreach ($ratings as $rating) {
      $this->assertEquals('zombies', $rating->getGame()->getGenreCode());
    }
  }
}

// Execute: phpunit src/Test/Unit/GameTest

?>
