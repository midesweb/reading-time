<?php

namespace Midesweb\Tests\ReadingTime;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Midesweb\ReadingTime\EstimatedReadingTime;

class EstimatedReadingTimeTest extends TestCase
{
  #[Test]
  public function itEstimatesReadingTimeOneMinuteMinimum() 
  {
    $readTimeCalculator = new EstimatedReadingTime('hola');
    $minutes = $readTimeCalculator->getEstimatedReadingMinutes();
    $this->assertEquals(1, $minutes);
  }

  #[Test]
  public function itGetCorrectReadTimeInEnglish()
  {
    $content = str_repeat("palabra ", 250);
    $estimator = new EstimatedReadingTime($content);

    $readTime = $estimator->getReadTime();

    $this->assertStringContainsString('minutes', $readTime);
    $this->assertStringContainsString('2', $readTime);
  }

  #[Test]
  public function itGetCorrectReadTimeInSpanish()
  {
    $content = str_repeat("palabra ", 25000);
    $estimator = new EstimatedReadingTime($content);
    $estimator->setLanguage('es');

    $readTime = $estimator->getReadTime();

    $this->assertStringContainsString('horas', $readTime);
    $this->assertStringContainsString('3', $readTime);
  }

  #[Test]
  public function itGetCorrectReadTimeInFrench()
  {
    $content = str_repeat("palabra ", 7200);
    $estimator = new EstimatedReadingTime($content);
    $estimator->setLanguage('fr');

    $readTime = $estimator->getReadTime();

    $this->assertEquals('1 heure', $readTime);
  }
}