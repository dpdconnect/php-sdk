# Contributing


## How to run unit tests
Due to the nature of the project and the need to support many PHP versions the dev requirements aren't 
configured for PHP 7.1 and lower. To run unit tests for PHP 5.6 to 7.1 you must install PHPUnit 5.0.

```bash
$ composer remove --dev phpunit/phpunit
$ comopser require --dev phpunit/phpunit ^5.0
$ vendor/bin/phpunit
```

**Caution: Don't actually commit this, it is actually preferred to download the .phar files of PHPUnit
you need manually or install them globally**

Check the PHPUnit documentation for more information: https://phpunit.de/supported-versions.html
