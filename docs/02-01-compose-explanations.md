```json
{
  "require": {
    "php": ">=7.2",
    "guzzlehttp/guzzle": "^7.0",
    "illuminate/container": "^7.19"
  },
  "require-dev": {
    "inpsyde/php-coding-standards": "^0.13",
    "johnpbloch/wordpress-core": "^5.3",
    "codeception/codeception": "^4.1",
    "codeception/module-asserts": "^1.0.0",
    "brain/monkey": "^2.2",
    "symfony/var-dumper": "^5.1"
  }, 
  "replace": {
    "phpunit/phunit": "~8.0.0"
  }
}
```

### Production
- `"php": ">=7.2"`: Requirements need PHP 7.2+
- `"guzzlehttp/guzzle": "^7.0"`: Package for handling remote http requests
- `"illuminate/container": "^7.19"`: A package from Laravel for Dependency Injection Container to keep all services in plugin accessible globally.

### Dev
- `"inpsyde/php-coding-standards": "^0.13"`: for Inpsyde coding standards, we only need this for dev.
- `"johnpbloch/wordpress-core": "^5.3"`: WordPress core, we only need that for local Docker's container
- `"codeception/codeception": "^4.1"`: Codeception core for testing (built on top of PhpUnit)
- `"codeception/module-asserts": "^1.0.0"`: Assert Module for Codeception
- `"brain/monkey": "^2.2"`: For several expect functions that I learn from Paypal Plus Plugin.
- `"symfony/var-dumper": "^5.1"`: Just for dumping variables when coding. I like this dumper :)
