<?php

namespace Midesweb\ReadingTime;

class EstimatedReadingTime {

  private $content;

  public function __construct(string $content)
  {
    $this->content = $content;
  }

  public function updateContent(string $content) {
    $this->content = $content;
  }

  public function getEstimatedReadingMinutes() {
    $words = str_word_count( strip_tags( $this->content ) );
    $minutes = floor( $words / 120 );
    $seconds = floor( $words % 120 / ( 120 / 60 ) );

    if ( $seconds > 30 ) {
      $minutes ++;
    }

    return $minutes;
  }
}