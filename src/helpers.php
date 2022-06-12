<?php

if (!function_exists('is_blank')) {
    function is_blank(mixed $value): bool
    {
        if (null === $value) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('normalize_path')) {
    /**
     * Strips trailing slashes from path.
     */
    function normalize_path(string $path): string
    {
        return rtrim(trim($path), '/\\');
    }
}

if (!function_exists('normalize_text')) {
    function normalize_text(string $s): string
    {
        return mb_strtolower(trim($s));
    }
}

if (!function_exists('word_tokenize')) {
    /**
     * Return a tokenized copy of string (divide string into lists of words).
     *
     * @return string[]
     */
    function word_tokenize(string $s): array
    {
        $result = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/u', $s, -1, PREG_SPLIT_NO_EMPTY);

        return $result !== false ? $result : [];
    }
}
