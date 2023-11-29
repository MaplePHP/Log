# MaplePHP - PSR-3 Logger
PHP PSR-3 Logger library – your reliable companion for efficient logging in PHP applications. This library adheres to the PSR-3 standard, providing a seamless and standardized approach to logging messages across different components of your application.

### Stream/file handler

Create simple stream logger
```php
$log = new Logger(new StreamHandler("/path/to/logger.log"));
$log->warning("The user {firstname} has been added.", ["firstname" => "John", "lastname" => "Doe"]);
```

Create simple stream rotatables loggers. Will create a new log file if size is more than MAX_SIZE (5000 KB) and remove log files if total file count is more than MAX_COUNT 10.
```php
$log = new Logger(new StreamHandler("/path/to/logger.log", StreamHandler::MAX_SIZE, StreamHandler::MAX_COUNT));
$log->warning("The user {firstname} has been added.", ["firstname" => "John", "lastname" => "Doe"]);
```

### Database handler
```php
$log = new Logger(new DBHandler());
$log->warning("The user {firstname} has been added.", ["user_id" => 4, "firstname" => "Daniel"]);
```

### PHP error log handler (error_log())
You can (not required) specify a log file location in ErrorLogHandler. If argument is empty, then server default location.
```php
$log = new Logger(new ErrorLogHandler("/path/to/logger.log"));
$log->warning("The user {firstname} has been added.", ["firstname" => "John", "lastname" => "Doe", "data" => ["city" => "Stockholm", "coor" => "122,1212"]]);
```
