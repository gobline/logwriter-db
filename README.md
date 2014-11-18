# DB Log Writer Component - Mendo Framework

```Mendo\Logger\Writer\DbLogWriter``` writes log information to a database.

## Usage

```php
$metadata = new Mendo\Logger\Writer\TableMetadata('logs');
$metadata
    ->setColumnLevel('level')
    ->setColumnMessage('message')
    ->setColumnExceptionCode('exception_code')
    ->setColumnExceptionStackTrace('exception_stack_trace');

$writer = new Mendo\Logger\Writer\DbLogWriter($pdo, $metadata);

$writer->info('hello world');
```

## Installation

You can install Mendo DB Log Writer using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require mendoframework/logwriter-db
```