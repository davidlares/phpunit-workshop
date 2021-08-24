<?php

  class Game {

    // protected attributes
    protected $title;
    protected $imagePath;
    protected $ratings;

    // getters and setters
    public function getTitle() {
      return $this->title;
    }

    public function setTitle($value) {
      $this->title = $value;
    }

    public function getImagePath() {
      // validating
      if ($this->imagePath == null) {
        return '/web/images/placeholder.jpg';
      }
      return $this->imagePath;
    }

    public function setImagePath($value) {
      $this->imagePath = $value;
    }

    public function getRatings() {
      return $this->ratings;
    }

    public function setRatings($value) {
      $this->ratings = $value;
    }

    public function toArray() {
      $array = ['title' => $this->getTitle(), 'imagePath' => $this->getImagePath(), 'ratings' => [],];
      foreach ($this->getRatings() as $rating) {
        $array['ratings'][] = $rating->toArray();
      }
      return $array;
    }

    // methods
    public function isRecommended($user) {
      $compatibility = $user->getGenreCompatibility($this->getGenreCode());
      return $this->getAverageScore() / 10 * $compatibility >= 3;
    }

    public function getAverageScore() {
      $ratings = $this->getRatings(); // useful logic, makes testing simpler
      $numRatings = count($ratings);
      // fixing
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
      // returning the average -> first run: possible division by zero
      return $total / $numRatings;
    }

  }
