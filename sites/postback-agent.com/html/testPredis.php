<?php
require "../cgi-bin/predis/autoload.php";
Predis\Autoloader::register();

// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
    $redis = new Predis\Client();
/*
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "127.0.0.1",
        "port" => 6379));
*/
    echo "Successfully connected to Redis";
}
catch (Exception $e) {
    echo "Couldn't connect to Redis";
    echo $e->getMessage();
}

$redis->set("hello_world", "Hi from php!");
$value = $redis->get("hello_world");
var_dump($value);

echo ($redis->exists("Santa Claus")) ? "true" : "false";
?>
