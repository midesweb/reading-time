<?php

namespace Midesweb\ReadingTime;

class EstimatedReadingTime {

  private $content;
  private $language = "EN";

  private const SUPPORTED_LANGUAGES = ['EN', 'ES'];

  public function __construct(string $content)
  {
    $this->content = $content;
  }

  public function updateContent(string $content) {
    $this->content = $content;
    return $this;
  }

  public function setLanguage($lang) {
    $lang = strtoupper($lang);

    if (!in_array($lang, self::SUPPORTED_LANGUAGES)) {
      throw new \InvalidArgumentException("Unsupported language: {$lang}");
    }

    $this->language = $lang;
    return $this; // permite encadenamiento
  }

  public function getEstimatedReadingMinutes() {
    $words = str_word_count(strip_tags($this->content));
    $minutes = floor($words / 120);
    $seconds = floor($words % 120 / (120 / 60));

    if ($seconds > 30) {
      $minutes++;
    }

    return $minutes;
  }

  public function getReadTime() {
    $minutes = $this->getEstimatedReadingMinutes();

    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;

    switch ($this->language) {
      case 'ES':
        if ($hours > 0) {
          return "{$hours} hora" . ($hours > 1 ? "s" : "") . 
                 ($remainingMinutes > 0 ? " y {$remainingMinutes} minuto" . ($remainingMinutes > 1 ? "s" : "") : "");
        }
        return "{$minutes} minuto" . ($minutes > 1 ? "s" : "");
      
      case 'EN':
      default:
        if ($hours > 0) {
          return "{$hours} hour" . ($hours > 1 ? "s" : "") . 
                 ($remainingMinutes > 0 ? " and {$remainingMinutes} minute" . ($remainingMinutes > 1 ? "s" : "") : "");
        }
        return "{$minutes} minute" . ($minutes > 1 ? "s" : "");
    }
  }
}
