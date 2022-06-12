# Stopwords for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masroore/php-stopwords.svg?style=flat-square)](https://packagist.org/packages/masroore/php-stopwords)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masroore/php-stopwords/run-tests?label=tests)](https://github.com/masroore/php-stopwords/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masroore/php-stopwords/Check%20&%20fix%20styling?label=code%20style)](https://github.com/masroore/php-stopwords/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/masroore/php-stopwords.svg?style=flat-square)](https://packagist.org/packages/masroore/php-stopwords)

## Overview ##

Stopwords in multiple languages that you can easily use with your PHP applications.

## Supported languages

Currently provides stopwords for the following languages:

* Arabic
* Azerbaijani
* Bengali
* Danish
* Dutch
* English
* Finnish
* French
* German
* Greek
* Hungarian
* Indonesian
* Italian
* Kazakh
* Nepali
* Norwegian
* Portuguese
* Romanian
* Russian
* Slovene
* Spanish
* Swedish
* Tajik
* Turkish


## Installation

> **Requires [PHP 8.0+](https://php.net/releases/)**

You can install the package via composer:

```bash
composer require masroore/stopwords
```

## Usage

```php
$stopwords = new Kaiju\Stopwords\Stopwords();

// get the list of available languages
print_r($stopwords->getLanguages());

// load stopwords for a language
$stopwords->load('english');

// load stopwords for multiple languages
$stopwords->load(['english', 'french']);

// load stopwords for all available languages
$stopwords->load('*');

// check if the given word is a stop-word
$stopwords->isStopword('the'); // TRUE
$stopwords->isStopword('America'); // FALSE

// return a tokenized copy of the text, with stop-words and punctuation marks removed
$text = "Good muffins cost $3.88\nin New York.  Please buy me two of them.\n\nThanks!\n";
print_r($stopwords->strip($text));
// ["Good","muffins","cost","$3.88","New","York","Please","buy","two","Thanks"]

echo $stopwords->clean($text);
// "Good muffins cost $3.88 New York Please buy two Thanks"

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering to contribute to Collision. All the contribution guidelines are mentioned [here](CONTRIBUTING.md).

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Masroor Ehsan](https://github.com/masroore)
- [All Contributors](../../contributors)

## License

Collision is an open-sourced software licensed under the [MIT license](LICENSE.md).
