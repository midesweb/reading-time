<?php

declare(strict_types=1);

namespace Midesweb\ReadingTime;

class EstimatedReadingTime
{
    private $content;
    private $language = "EN";
    private $speed = 120;

    private const SUPPORTED_LANGUAGES = ['EN', 'ES', 'FR'];

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function updateContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function setLanguage($lang)
    {
        $lang = strtoupper($lang);

        if (!in_array($lang, self::SUPPORTED_LANGUAGES, true)) {
            throw new \InvalidArgumentException("Unsupported language: {$lang}");
        }

        $this->language = $lang;
        return $this;
    }

    public function setReadingWordsPerMinute($speed): static
    {
        $this->speed = $speed;
        return $this;
    }

    public function getEstimatedReadingSeconds()
    {
        $words = str_word_count(strip_tags($this->content));
        $seconds = floor($words / $this->speed * 60);

        return $seconds < 1 ? 1 : $seconds;
    }

    public function getEstimatedReadingMinutes()
    {
        $seconds = $this->getEstimatedReadingSeconds();
        $minutes = floor($seconds / 60);

        if ($seconds % 60 > 30) {
            $minutes++;
        }

        return $minutes < 1 ? 1 : $minutes;
    }

    public function getReadTime()
    {
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

            case 'FR':
                if ($hours > 0) {
                    return "{$hours} heure" . ($hours > 1 ? "s" : "") .
                            ($remainingMinutes > 0 ? " et {$remainingMinutes} minute" . ($remainingMinutes > 1 ? "s" : "") : "");
                }
                return "{$minutes} minute" . ($minutes > 1 ? "s" : "");

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
