<?php

declare(strict_types=1);

namespace Kaiju\Stopwords\Tokenizer;

interface Tokenizer
{
    /**
     * Tokenize a string.
     */
    public function tokenize(string $string): array;

    /**
     * Normalize a string.
     */
    public function normalize(string $string): string;
}
