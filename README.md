

# MaplePHP - PSR-3 Logger
PHP PSR-3 Logger library – your reliable companion for efficient logging in PHP applications. This library adheres to the PSR-3 standard, providing a seamless and standardized approach to logging messages across different components of your application.


## Log-levels

1. **emergency:** System is unusable
2. **alert:** Action must be taken immediately
3. **critical:** Critical conditions
4. **error:** Runtime errors that do not require immediate action but usually logged and monitored.
5. **warning:** Exceptional occurrences that are not errors.
6. **notice:** Normal but significant events.
7. **info:** Interesting events (User logs in, SQL logs.)
8. **debug:** Detailed debug information.
9. **log:** Logs with an arbitrary level.


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
