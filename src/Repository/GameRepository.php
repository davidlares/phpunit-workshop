<?php

require __DIR__ . "/../Entity/Rating.php"; // Game class
require __DIR__ . "/../Entity/Game.php"; // Game class

class GameRepository {

  // PDO connection
  protected $pdo;

  public function __construct() {
    // PDO setup
    try {
      $this->pdo = new PDO('mysql:host=localhost;dbname=gamebook_test','root','administrator');
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function findById($id) {
    $statement = $this->pdo->prepare('SELECT * FROM game where id = ?');
    $statement->execute([$id]); // args escaped
    $game = $statement->fetchObject('Game'); // fetching the Game
    return $game;
  }

  function saveGameRating($gameId, $userId, $score) {
    // some sort of update = replace existing
    $statement = $this->pdo->prepare('INSERT INTO rating (game_id, user_id, score) VALUES(?, ?, ?)');
    return $statement->execute([$gameId, $userId, $score]);
  }

  public function findByUserId($id) {
    $games = [];
    for($i = 1; $i <= 6; $i++) {
      // each iteration instance
      $game = new Game();
      $game->setTitle("Game ". $i);
      $game->setImagePath('/web/images/game.jpg');
      // adding rating
      $rating = new Rating();
      $rating->setScore(4.5);
      $game->setRatings([$rating]);
      // Adding to the array
      $games[] = $game;
    }
    // returning the array
    return $games;
  }

}


?>
