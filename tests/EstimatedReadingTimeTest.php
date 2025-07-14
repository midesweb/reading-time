<?php

declare(strict_types=1);

namespace Midesweb\Tests\ReadingTime;

use Midesweb\ReadingTime\EstimatedReadingTime;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

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
    public function itEstimatesReadingTimeOneSecondMinimum()
    {
        $readTimeCalculator = new EstimatedReadingTime('');
        $seconds = $readTimeCalculator->getEstimatedReadingSeconds();
        $this->assertEquals(1, $seconds);
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

    #[Test]
    public function itCalculatesCorrectMinutesChangingSeepd()
    {
        $speed = 150;
        $content = str_repeat("palabra ", $speed * 30);
        $readTimeCalculator = new EstimatedReadingTime($content);
        $minutes = $readTimeCalculator->setReadingWordsPerMinute($speed)->getEstimatedReadingMinutes();
        $this->assertEquals(30, $minutes);
    }
}
