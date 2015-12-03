# DB Log Writer component

```Gobline\Logger\Writer\DbLogWriter``` writes log information to a database.

## Usage

```php
$metadata = new Gobline\Logger\Writer\TableMetadata('logs');
$metadata
    ->setColumnLevel('level')
    ->setColumnMessage('message')
    ->setColumnExceptionCode('exception_code')
    ->setColumnExceptionStackTrace('exception_stack_trace');

$writer = new Gobline\Logger\Writer\DbLogWriter($pdo, $metadata);

$writer->info('hello world');
```

## Installation

You can install the DB Log Writer component using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require gobline/logwriter-db
```