<?php

declare(strict_types=1);

namespace Kaiju\Stopwords\Tests\Tokenizer;

use Kaiju\Stopwords\Tokenizer\SimpleTokenizer;
use Kaiju\Stopwords\Tokenizer\Tokenizer;
use PHPUnit\Framework\TestCase;

class SimpleTokenizerTest extends TestCase
{
    private $tokenizer;

    public function tokenizeProvider(): array
    {
        return [
            [' ', []],
            [" Hello\n\t", ['Hello']],
            ["Good muffins cost $3.88\nin New York.\n\n\tThanks!\n", ['Good', 'muffins', 'cost', '$3.88', 'in', 'New', 'York', 'Thanks']],
        ];
    }

    protected function setUp(): void
    {
        $this->tokenizer = new SimpleTokenizer();
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(Tokenizer::class, $this->tokenizer);
    }

    /**
     * @dataProvider normalizeProvider
     */
    public function testNormalize(string $input, string $expected): void
    {
        self::assertEquals($expected, $this->tokenizer->normalize($input));
    }

    /**
     * @dataProvider tokenizeProvider
     */
    public function testTokenize(string $input, array $expected): void
    {
        $tokens = $this->tokenizer->tokenize($input);
        self::assertIsArray($tokens);
        self::assertSame($expected, $tokens);
    }

    public function normalizeProvider(): array
    {
        return [
            [' ', ''],
            ['Hello', 'hello'],
        ];
    }
}
