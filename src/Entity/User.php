<?php

  class User {

    protected $ratings;

    // getters
    public function getRatings() {
      return $this->ratings;
    }

    // methods
    public function findRatingsByGenre($genreCode) {
      $filteredRatings = [];
      // iterating
      foreach($this->getRatings() as $rating) {
        // comparing genres
        if($rating->getGame()->getGenreCode() == $genreCode) {
          $filteredRatings[] = $rating;
        }
      }
      return $filteredRatings;
    }

    public function getGenreCompatibility($genreCode) {
      $ratings = $this->findRatingsByGenre($genreCode);
      $numRatings = count($ratings);
      // checking zero = fixing
      if($numRatings == 0) {
        return null;
      }

      // count
      $total = 0;
      foreach($ratings as $rating) {
        $score = $rating->getScore();
        if($score === null) {
          $numRatings--;
          continue;
        }
        $total += $score;
      }
      return $total / $numRatings;
    }
  }

?>
