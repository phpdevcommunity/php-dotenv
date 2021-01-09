# php-dotenv
# Loads environment variables from .env file to getenv(), $_ENV and $_SERVER.

```
APP_ENV=dev
DATABASE_DNS=mysql:host=localhost;dbname=test;
DATABASE_USER=root
DATABASE_PASSWORD=root
```


```
**How to use ?**
```php
<?php
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();

echo getenv('APP_ENV');
// dev
echo getenv('DATABASE_DNS')
// mysql:host=localhost;dbname=test;
```
Ideal for small project
Simple and easy!
