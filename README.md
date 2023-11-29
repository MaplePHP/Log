
# MaplePHP - PSR-3 Logger
PHP PSR-3 Logger library – your reliable companion for efficient logging in PHP applications. This library adheres to the PSR-3 standard, providing a seamless and standardized approach to logging messages across different components of your application.

## Stream/file handler

#### Add namespaces
```php
use MaplePHP\Log\Logger;
use MaplePHP\Log\Handlers\StreamHandler;
```
#### Create simple stream logger
```php
$log = new Logger(new StreamHandler("/path/to/logger.log"));
$log->warning("The user {firstname} has been added.", ["firstname" => "John", "lastname" => "Doe"]);
```
#### Rotatable log files
Create simple stream rotatables loggers. Will create a new log file if size is more than MAX_SIZE (5000 KB) and remove log files if total file count is more than MAX_COUNT 10.
```php
$log = new Logger(new StreamHandler("/path/to/logger.log", StreamHandler::MAX_SIZE, StreamHandler::MAX_COUNT));
$log->warning("The user {firstname} has been added.", ["firstname" => "John", "lastname" => "Doe"]);
```

## Database handler
#### Add namespaces
```php
use MaplePHP\Log\Logger;
use MaplePHP\Log\Handlers\DBHandler;
```

#### 1. Connect to the database.
[MaplePHP Query](https://github.com/MaplePHP/Query)

#### 2. Create database table
Execute bellow once to create the database table.
```php
$dbHandler = new DBHandler();
$error = $dbHandler->create();
if (count($error) > 0) {
	echo "<pre>";
	print_r($error);
	echo "</pre>";
}
```
#### 3. Write to database log
```php
$log = new Logger(new DBHandler());
$log->warning("The user {firstname} has been added.", ["user_id" => 4, "firstname" => "Daniel"]);
```

## PHP error log handler (error_log())
You can (not required) specify a log file location in ErrorLogHandler. If argument is empty, then server default location.

#### Add namespaces
```php
use MaplePHP\Log\Logger;
use MaplePHP\Log\Handlers\ErrorLogHandler;
```
```php
$log = new Logger(new ErrorLogHandler("/path/to/logger.log"));
$log->warning("The user {firstname} has been added.", ["firstname" => "John", "lastname" => "Doe", "data" => ["city" => "Stockholm", "coor" => "122,1212"]]);
```
