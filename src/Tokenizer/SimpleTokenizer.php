<?php

declare(strict_types=1);

namespace Kaiju\Stopwords\Tokenizer;

class SimpleTokenizer implements Tokenizer
{
    public function tokenize(string $string): array
    {
        return word_tokenize($string);
    }

    public function normalize(string $string): string
    {
        return normalize_text($string);
    }
}
