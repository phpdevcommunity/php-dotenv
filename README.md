# PHP-DotEnv 

[![Latest Stable Version](https://poser.pugx.org/devcoder-xyz/php-dotenv/v)](https://packagist.org/packages/devcoder-xyz/php-dotenv) [![Total Downloads](https://poser.pugx.org/devcoder-xyz/php-dotenv/downloads)](https://packagist.org/packages/devcoder-xyz/php-dotenv) [![Latest Unstable Version](https://poser.pugx.org/devcoder-xyz/php-dotenv/v/unstable)](//packagist.org/packages/devcoder-xyz/php-dotenv) [![License](https://poser.pugx.org/devcoder-xyz/php-dotenv/license)](https://packagist.org/packages/devcoder-xyz/php-dotenv)
[![PHP Version Require](http://poser.pugx.org/devcoder-xyz/php-dotenv/require/php)](https://packagist.org/packages/devcoder-xyz/php-dotenv)

## Introduction
PHP-DotEnv is a lightweight PHP library designed to simplify the management of environment variables in your PHP applications. It provides an elegant solution for loading configuration values from a `.env` file into the environment variables accessible via `getenv()`, `$_ENV`, and `$_SERVER`. This documentation aims to guide you through the installation, usage, and features of PHP-DotEnv.

## Installation

To install PHP-DotEnv, you can use [Composer](https://getcomposer.org/), the dependency manager for PHP.

### Composer Require
```bash
composer require devcoder-xyz/php-dotenv
```

## Requirements

- PHP version 7.4 or higher

## Usage

### 1. Define Environment Variables

Before using PHP-DotEnv, you need to define your environment variables in a `.env` file. This file should be placed in the root directory of your project. Each line in the file should follow the `KEY=VALUE` format.

```dotenv
APP_ENV=dev
DATABASE_DNS=mysql:host=localhost;dbname=test;
DATABASE_USER="root"
DATABASE_PASSWORD=root
MODULE_ENABLED=true
NUMBER_LITERAL=0
NULL_VALUE=null
```

### 2. Load the Variables

After defining your environment variables, you can load them into your PHP application using PHP-DotEnv.

```php
<?php
use DevCoder\DotEnv;

$absolutePathToEnvFile = __DIR__ . '/.env';

(new DotEnv($absolutePathToEnvFile))->load();
```

### 3. Access Environment Variables

Once loaded, you can access the environment variables using PHP's `getenv()` function.

```php
/**
 * Retrieve the value of DATABASE_DNS
 */
var_dump(getenv('DATABASE_DNS'));
```

### Automatic Type Conversion

PHP-DotEnv provides automatic type conversion for certain types of values:

- Booleans: Processed as `true` or `false`.
- Quoted Strings: Surrounding quotes are removed.
- Null Values: Converted to `null`.
- Numeric Values: Converted to integers or floats.

## Processors

PHP-DotEnv allows you to define custom processors to handle specific types of values in your `.env` file. These processors enable you to control how values are parsed and converted.

### BooleanProcessor

The `BooleanProcessor` converts boolean values specified in the `.env` file to PHP boolean types (`true` or `false`).

```dotenv
MODULE_ENABLED=true
```

### QuotedProcessor

The `QuotedProcessor` removes surrounding quotes from quoted strings in the `.env` file.

```dotenv
DATABASE_USER="root"
```

### NullProcessor

The `NullProcessor` converts the string "null" to the PHP `null` value.

```dotenv
NULL_VALUE=null
```

### NumberProcessor

The `NumberProcessor` converts numeric values to integers or floats.

```dotenv
NUMBER_LITERAL=0
```

## Conclusion

PHP-DotEnv offers a straightforward and efficient solution for managing environment variables in PHP applications. By providing automatic type conversion and customizable processors, it simplifies the process of loading and handling configuration values from `.env` files. Whether you're working on a small project or a large-scale application, PHP-DotEnv can help streamline your development process and ensure smooth configuration management. Explore its features, integrate it into your projects, and experience the convenience it brings to your PHP development workflow.