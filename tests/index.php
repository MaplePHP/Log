<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$prefix = "PHPFuse";
$dir = dirname(__FILE__) . "/../";

//require_once("{$dir}../_vendors/composer/vendor/autoload.php");

spl_autoload_register(function ($class) use ($dir, $prefix) {
    $classFilePath = null;
    $class = str_replace("\\", "/", $class);
    $exp = explode("/", $class);
    $sh1 = array_shift($exp);
    $path = implode("/", $exp) . ".php";
    if ($sh1 !== $prefix) {
        $path = "{$sh1}/{$path}";
    }

    $filePath = $dir . "../" . $path;
    require_once($filePath);
});

use PHPFuse\Log\Logger;
use PHPFuse\Log\Handlers\StreamHandler;
use PHPFuse\Log\Handlers\ErrorLogHandler;
use PHPFuse\Log\Handlers\DBHandler;

use PHPFuse\Query\Connect;

$connect = new Connect("localhost", "creative", "330465!!!", "Test");
$connect::setPrefix("ca_");
$connect->execute();


/*
$log = new Logger(new StreamHandler("/var/www/html/systems/logger.log",
StreamHandler::MAX_SIZE, StreamHandler::MAX_COUNT));
$log->warning("The user {firstname} has been added.",
["firstname" => "John", "lastname" => "Doe", "data" => ["city" => "Stockholm", "coor" => "122,1212"]]);
*/

/*
$log = new Logger(new DBHandler());
$log->warning("The datahas been {firstname} has been added.", ["user_id" => 4, "firstname" => "Daniel"]);
 */

/*
PHP Error_log
$log = new Logger(new ErrorLogHandler("/var/www/html/systems/test33.log"));
$log->warning("The user {firstname} has been added.", [
    "firstname" => "John", "lastname" => "Doe", "data" => ["city" => "Stockholm", "coor" => "122,1212"]
]);
die("DONE?");
/*


class test {
    use \PHPFuse\Log\LoggerTrait;

    function __construct() {

    }
}

new test();
 */



/*
class test {


    public $std;

    function __construct() {
        $this->std = new stdClass();


        $this->www = "wdwq";
    }



    public function __set($key, $value)
    {
        $this->std->{$key} = $value;
    }

    public function __get($key)
    {
        return $this->std->{$key};
    }


}


$obj = new test();
echo $obj->www;

 */
