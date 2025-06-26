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
  public function itGetCorrectReadTimeInSpanish()
  {
    $content = str_repeat("palabra ", 250); // Genera 250 palabras
    $estimator = new EstimatedReadingTime($content);
    // $estimator->setLanguage('es');

    $readTime = $estimator->getReadTime();

    $this->assertStringContainsString('minuto', $readTime);
    $this->assertStringContainsString('2', $readTime);
  }
}