# php-dotenv
# Loads environment variables from .env file to getenv(), $_ENV and $_SERVER.
[![Latest Stable Version](https://poser.pugx.org/devcoder-xyz/php-dotenv/v)](//packagist.org/packages/devcoder-xyz/php-dotenv) [![Total Downloads](https://poser.pugx.org/devcoder-xyz/php-dotenv/downloads)](//packagist.org/packages/devcoder-xyz/php-dotenv) [![Latest Unstable Version](https://poser.pugx.org/devcoder-xyz/php-dotenv/v/unstable)](//packagist.org/packages/devcoder-xyz/php-dotenv) [![License](https://poser.pugx.org/devcoder-xyz/php-dotenv/license)](//packagist.org/packages/devcoder-xyz/php-dotenv)
```
APP_ENV=dev
DATABASE_DNS=mysql:host=localhost;dbname=test;
DATABASE_USER="root"
DATABASE_PASSWORD=root
MODULE_ENABLED=true
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