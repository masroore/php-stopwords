<?php

declare(strict_types=1);

namespace Kaiju\Stopwords;

use Kaiju\Stopwords\Exceptions\LanguageNotFoundException;
use Kaiju\Stopwords\Tokenizer\SimpleTokenizer;
use Kaiju\Stopwords\Tokenizer\Tokenizer;
use RuntimeException;

class Stopwords
{
    /**
     * @var string[]
     */
    private static array $languages = [];

    /**
     * @var string[]
     */
    private array $stopwords = [];

    private Tokenizer $tokenizer;

    public function __construct(private string $resourceDir = '', ?Tokenizer $tokenizer = null)
    {
        if (is_blank($this->resourceDir)) {
            $this->resourceDir = __DIR__ . '/../resources/stopwords';
        }
        $this->resourceDir = normalize_path($this->resourceDir);

        if (null === $tokenizer) {
            $tokenizer = new SimpleTokenizer();
        } elseif (!$tokenizer instanceof Tokenizer) {
            throw new RuntimeException('Invalid tokenizer passed to Stopwords');
        }

        $this->tokenizer = $tokenizer;

        $this->reset();
    }

    public static function make(string $resourceDir = '', string|array $languages = ['english']): static
    {
        return (new self($resourceDir))->load($languages);
    }

    private function scanLanguages(): array
    {
        if (empty(self::$languages)) {
            $paths = glob($this->resourceDir . '/*.txt');
            if ($paths !== false) {
                self::$languages = array_map(static fn (string $path): string => basename($path, '.txt'), $paths);
            }
        }

        return self::$languages;
    }

    /**
     * @param string|string[] $languages
     */
    public function load(string|array $languages): self
    {
        if (!is_array($languages)) {
            $languages = ($languages === '*') ? self::$languages : [$languages];
        }

        foreach ($languages as $lang) {
            $lang = trim($lang);
            if (is_blank($lang)) {
                continue;
            }

            if (!in_array($lang, self::$languages, true)) {
                throw new LanguageNotFoundException("Invalid language: $lang");
            }

            $this->loadLanguageFile($lang);
        }

        return $this;
    }

    public function getResourceDir(): string
    {
        return $this->resourceDir;
    }

    /**
     * @return string[]
     */
    public function getStopwords(): array
    {
        return $this->stopwords;
    }

    public function reset(): void
    {
        $this->stopwords = self::$languages = [];
        $this->scanLanguages();
    }

    /**
     * @return string[]
     */
    public function getLanguages(): array
    {
        return self::$languages;
    }

    public function isStopword(string $s): bool
    {
        return in_array($this->tokenizer->normalize($s), $this->stopwords, true);
    }

    /**
     * Strip stopwords and punctuation marks from an input text.
     * Returns an array that represents the text with the specified stopwords removed.
     *
     * @return string[]
     */
    public function strip(string $s): array
    {
        /** @var string[] $stripped */
        $stripped = [];
        foreach ($this->tokenizer->tokenize($s) as $word) {
            if (!is_blank($word) && !$this->isStopword($word)) {
                $stripped[] = $word;
            }
        }

        return $stripped;
    }

    /**
     * Strip stopwords and punctuation marks from an input text.
     */
    public function clean(string $s): string
    {
        return implode(' ', $this->strip($s));
    }

    private function loadLanguageFile(string $lang): void
    {
        $path = "{$this->resourceDir}/{$lang}.txt";
        $words = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($words !== false) {
            $words = array_map(fn (string $s): string => $this->tokenizer->normalize($s), $words);
            $words = array_unique(array_filter($words));
            foreach ($words as $word) {
                if (!in_array($word, $this->stopwords, true)) {
                    $this->stopwords[] = $word;
                }
            }
        }
    }
}
