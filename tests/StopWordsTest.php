<?php

declare(strict_types=1);

namespace Kaiju\Stopwords\Tests;

use Kaiju\Stopwords\Stopwords;
use PHPUnit\Framework\TestCase;

class StopWordsTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testFormat(string $language, string $original, string $clean): void
    {
        $stopWords = StopWords::make('', $language);
        self::assertEquals($clean, $stopWords->clean($original));
    }

    public function provider(): array
    {
        return [
            ['english', "Good muffins cost $3.88\nin New York.  Please buy me two of them.\n\nThanks!\n", 'Good muffins cost $3.88 New York Please buy two Thanks'],
            ['spanish', 'ante a mi casa', 'casa'],
            ['swedish', 'Trädgårdsägare är beredda att pröva vad som helst för att bli av med de hatade mördarsniglarna åäö', 'Trädgårdsägare beredda pröva helst hatade mördarsniglarna åäö'],
        ];
    }
}
