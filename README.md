# php-dotenv
# Loads environment variables from .env file to getenv(), $_ENV and $_SERVER.
[![Latest Stable Version](https://poser.pugx.org/devcoder-xyz/php-dotenv/v)](https://packagist.org/packages/devcoder-xyz/php-dotenv) [![Total Downloads](https://poser.pugx.org/devcoder-xyz/php-dotenv/downloads)](https://packagist.org/packages/devcoder-xyz/php-dotenv) [![Latest Unstable Version](https://poser.pugx.org/devcoder-xyz/php-dotenv/v/unstable)](//packagist.org/packages/devcoder-xyz/php-dotenv) [![License](https://poser.pugx.org/devcoder-xyz/php-dotenv/license)](https://packagist.org/packages/devcoder-xyz/php-dotenv)
[![PHP Version Require](http://poser.pugx.org/devcoder-xyz/php-dotenv/require/php)](https://packagist.org/packages/devcoder-xyz/php-dotenv)

## Installation

Use [Composer](https://getcomposer.org/)

### Composer Require
```
composer require devcoder-xyz/php-dotenv
```

## Requirements

* PHP version 7.4

**How to use ?**

```
APP_ENV=dev
DATABASE_DNS=mysql:host=localhost;dbname=test;
DATABASE_USER="root"
DATABASE_PASSWORD=root
MODULE_ENABLED=true
NUMBER_LITERAL=0
NULL_VALUE=null
```

## Load the variables

```php
<?php
use DevCoder\DotEnv;

$absolutePathToEnvFile = __DIR__ . '/.env';

(new DotEnv($absolutePathToEnvFile))->load();
```

# Use them!
```php
/**
 * string(33) "mysql:host=localhost;dbname=test;" 
 */
var_dump(getenv('DATABASE_DNS'));

/**
 * Removes double and single quotes from the variable:
 * 
 * string(4) "root" 
 */
var_dump(getenv('DATABASE_USER'));

/**
 * Processes booleans as such:
 * 
 * bool(true) 
 */
var_dump(getenv('MODULE_ENABLED'));

/**
 * Process the numeric value:
 * 
 * int(0) 
 */
var_dump(getenv('NUMBER_LITERAL'));

/**
 * Check for literal null values:
 * 
 * NULL
 */
var_dump(getenv('NULL_VALUE'));
```

Ideal for small project

Simple and easy!

# Processors

Also the variables are parsed according to the configuration passed as parameter to the constructor. The available processors are:

## BooleanProcessor

``VARIABLE=false`` will be processed to ```bool(false)```

NOTE: ``VARIABLE="true"`` will be processed to ```string(4) "true"```

## QuotedProcessor

``VARIABLE="anything"`` will be processed to ```string(8) "anything"```

## NullProcessor

``VARIABLE=null`` will be processed to ```NULL```

## NumberProcessor

``VARIABLE=0`` will be processed to ```int(0)```

``VARIABLE=0.1`` will be processed to ```float(0.1)```