<?php

use PHPUnit\Framework\TestCase;
// building tests from scratch with PHPUnit
require __DIR__ . "/../../Entity/Game.php";

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

  public function testIsRecommended_With5_ReturnsTrue() {
    // mocking
    $game = $this->getMockBuilder('Game')->addMethods(['getAverageScore'])->getMock(); // assigning mock and function
    $game->method('getAverageScore')->willReturn(5); // mocked value
    // assertion based on a function
    $this->assertTrue($game->isRecommended());
  }
}

// Execute: phpunit src/Test/Unit/GameTest

?>
