<?php

  class Game {

    // protected attributes
    protected $title;
    protected $imagePath;
    protected $rating;

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

    public function getRating() {
      return $this->rating;
    }

    public function setRating($value) {
      $this->rating = $value;
    }

    // methods
    public function isRecommended() {
      return $this->getAverageScore() >= 3;
    }

  }
