<?php

use PHPUnit\Framework\TestCase;
// building tests from scratch with PHPUnit
require __DIR__ . "/../../Entity/Game.php";
require __DIR__ . "/../../Entity/User.php";

// inherited PHPUnit
class GameTest extends TestCase {

  // test scenarios
  public function testImage_WithNull_ReturnsPlaceholder() {
    $game = new Game(); // instance
    $game->setImagePath(null); // default
    $this->assertEquals('/web/images/placeholder.jpg', $game->getImagePath()); // assertion
  }

  public function testImage_WithPath_ReturnPath() {
    $game = new Game(); // instance
    $game->setImagePath('/web/images/game.jpg'); // default
    $this->assertEquals('/web/images/game.jpg', $game->getImagePath()); // assertion
    // $this->assertEquals('/web/images/placeholder.jpg', $game->getImagePath()); // assertion
  }

  // public function testIsRecommended_With5_ReturnsTrue() {
  //   // mocking
  //   $game = $this->getMockBuilder('Game')->onlyMethods(['getAverageScore'])->getMock(); // assigning mock and function
  //   $game->method('getAverageScore')->willReturn(5); // mocked value
  //   // assertion based on a function
  //   $this->assertTrue($game->isRecommended());
  // }

  public function testAverageCode_WithoutRatings_ReturnsNull() {
    // instance
    $game = new Game();
    $game->setRatings([]);
    $this->assertNull($game->getAverageScore()); // null assertion (comparison)
  }

  public function testAverageCode_With6And8_Returns7() {
    //mocking score
    $rat1 = $this->getMockBuilder('Game')->addMethods(['getScore'])->getMock();
    $rat1->method('getScore')->willReturn(6);
    $rat2 = $this->getMockBuilder('Game')->addMethods(['getScore'])->getMock();
    $rat2->method('getScore')->willReturn(8);
    //mocking ratings
    $game = $this->getMockBuilder('Game')->onlyMethods(['getRatings'])->getMock();
    $game->method('getRatings')->willReturn([$rat1, $rat2]);
    // getting average
    $this->assertEquals(7, $game->getAverageScore());
  }

  public function testAverageCode_WithNullAnd5_Returns5() {
    //mocking score
    $rat1 = $this->getMockBuilder('Game')->addMethods(['getScore'])->getMock();
    $rat1->method('getScore')->willReturn(null);
    $rat2 = $this->getMockBuilder('Game')->addMethods(['getScore'])->getMock();
    $rat2->method('getScore')->willReturn(5);
    //mocking ratings
    $game = $this->getMockBuilder('Game')->onlyMethods(['getRatings'])->getMock();
    $game->method('getRatings')->willReturn([$rat1, $rat2]);
    // getting average
    $this->assertEquals(5, $game->getAverageScore());
  }

  public function testIsRecommended_WithCompability2AndScore10_ReturnsFalse() {
    //mocking both average and genre
    $game = $this->getMockBuilder('Game')->onlyMethods(['getAverageScore'])->addMethods(['getGenreCode'])->getMock();
    $game->method('getAverageScore')->willReturn(10);
    // mocking compatibility
    $user = $this->getMockBuilder('User')->onlyMethods(['getGenreCompatibility'])->getMock();
    $user->method('getGenreCompatibility')->willReturn(2);
    // asserting False
    $this->assertFalse($game->isRecommended($user));
  }

  public function testIsRecommended_WithCompability10AndScore10_ReturnsTrue() {
    //mocking both average and genre
    $game = $this->getMockBuilder('Game')->onlyMethods(['getAverageScore'])->addMethods(['getGenreCode'])->getMock();
    $game->method('getAverageScore')->willReturn(10);
    // mocking compatibility
    $user = $this->getMockBuilder('User')->onlyMethods(['getGenreCompatibility'])->getMock();
    $user->method('getGenreCompatibility')->willReturn(10);
    // asserting True
    $this->assertTrue($game->isRecommended($user));
  }
}

// Execute: phpunit src/Test/Unit/GameTest

?>
