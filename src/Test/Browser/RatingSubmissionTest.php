<?php

use PHPUnit\Extensions\Selenium2TestCase;
use PHPUnit\Framework\TestCase;

class RatingSubmissionTest extends Selenium2TestCase {

  // adding the setup = pre-test
  public function setUp() : void {
    $this->setHost('localhost'); // external server
    $this->setPort(4444); // port
    $this->setBrowserUrl('http://gamebook.test/web');
    $this->setBrowser('chrome');
  }

  // done after each test
  public function tearDown() : void {
    $this->stop();
  }

  public function testHomePage() {
    $this->url('/web');
    // finding span
    $content = $this->byCssSelector('li span.title')->text();
    $this->assertEquals("Game 1", $content);
  }

  public function testSubmitRating() {
    $this->timeouts()->implicitWait(2000); // 2 secs = sleep
    $this->url('/web');
    $this->byLinkText('Rate')->click();
    // form
    $form = $this->byTag('form');
    $form->byName('score')->value(5);
    $form->submit();
    // evaluating redirection
    $this->assertEquals('http://gamebook.test/web', $this->getBrowserUrl());
    // taking the screenshot
    $image = $this->currentScreenshot();
    file_put_contents(__DIR__. '/screenshots/submit-rating.jpg', $image);
  }
}

?>
