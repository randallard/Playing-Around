<?php

// CONNECT TO REDIS
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
}
catch (Exception $e) {
    echo "Couldn't connect to Redis";
    echo $e->getMessage();
}

//$redis->lpush("postbackQueue",$_POST);

/*  EXPECTED POST DATA

var postData = {
          "endpoint":{
            "method":"GET",
            "url":"http://sample_domain_endpoint.com/data?key={key}&value={value}&foo={bar}"
          },
          "data":[
            {
              "key":"Azureus",
              "value":"Dendrobates"
            },
            {
              "key":"Phyllobates",
              "value":"Terribilis"
            }
          ]
        };

*/

#       PROCESSING POST DATA 
#	store "method"
#	store "endpoint"
#	foreach data element
#		send [method]:[endpoint] to redis with {key}/{value}/{bar} replaced

	$thisMethod = $_POST["endpoint"]["method"];
	$thisStartUrl = $_POST["endpoint"]["url"];

	foreach($_POST["data"] as &$dataItem) {
		$thisUrl = $thisStartUrl;
		foreach($dataItem as $key => $value) {
			$thisUrl = str_replace('{'.$key.'}',$value,$thisUrl);
		}
		$thisUrl = str_replace('{','',$thisUrl);
		$thisUrl = str_replace('}','',$thisUrl);
		$redis->rpush("postbackQueue",$thisUrl); 
#	}
?>
