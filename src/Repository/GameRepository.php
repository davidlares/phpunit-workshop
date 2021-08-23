<?php

require __DIR__ . "/../Entity/Game.php"; // Game class

class GameRepository {

  public function findByUserId($id) {
    $games = [];
    for($i = 1; $i < 6; $i++) {
      // each iteration instance
      $game = new Game();
      $game->setTitle("Game ". $i);
      $game->setImagePath('/web/images/game.jpg');
      $game->setRating(4.5);
      // Adding to the array
      $games[] = $game;
    }
    // returning the array
    return $games;
  }

}


?>
