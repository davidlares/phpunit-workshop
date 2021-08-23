<?php

  // displaying the list of games
  require __DIR__ . "/../src/Repository/GameRepository.php";

  // getting the list from the database through the Repository
  $repo = new GameRepository();
  // calling a certain element
  $games = $repo->findByUserId(1);

  // Structure: index.php -> GameRepository -> Game
  // var_dump($games); // all items

?>

<!-- This is the place for rendering files -->

<ul>
  <?php foreach($games as $game): ?>
      <li>
        <?php echo $game->getTitle() ?>
        <br>
        <?php echo $game->getRating() ?>
        <img src="<?php echo $game->getImagePath() ?>">
      </li>
  <?php endforeach ?>
</ul>
