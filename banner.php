<?php

/*
Every time the image is loaded, the page visitor's info should be recorded in the MySQL
table web_count.
If a user with the same IP address, user-agent, and page URL hits the page again, the
view_date column has to be updated with the current date and time, as well as
views_count column has to be increased by 1.
 */

require 'vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;

defined('WEB_DEBUG') or define('WEB_DEBUG',false);
define('CURR_DATETIME', (new \DateTime())->format('Y-m-d H:i:s'));

$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'infohits',
	'server' => 'localhost',
	'username' => 'infohits',
	'password' => 'pass_to_infohits',
 
	// [optional]
	'charset' => 'utf8',
	'port' => 3306,
 
	// [optional] Table prefix
	'prefix' => '',
 
	// [optional] Enable logging (Logging is disabled by default for better performance)
	'logging' => true,
 
	// [optional] MySQL socket (shouldn't be used with server and port)
	//'socket' => '/tmp/mysql.sock',
 
	// [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	],
 
	// [optional] Medoo will execute those commands after connected to the database for initialization
	'command' => [
		'SET SQL_MODE=ANSI_QUOTES'
	]
]);

$user_ip = $_SERVER['REMOTE_ADDR'];
$user_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"none";
$user_useragent = $_SERVER['HTTP_USER_AGENT'];

$datas = $database->select("web_counter", [
	"id",
], [
	"ip_address" => $user_ip,
    "user_agent" => $user_useragent,
    "page_url" => $user_url,
]);

$similar_user_id = isset($datas[0]["id"]) ? $datas[0]["id"] : 0;

If ($similar_user_id) {
    //    view_date to be update: $curr_datetime 
    //        and  
    //    views_count increased by 1.
    $data = $database->update("web_counter", [
        "views_count[+]" => 1,
        "view_date" => CURR_DATETIME,
    ], [
        "id" => $similar_user_id,
    ]);
} else {
    //Every time the image is loaded, the page visitors info should be recorded in the MySQL
    //table web_count.
    //    $database->insert("web_counter", [
    //        "views_count" => 1,
    //        "ip_address" => $user_ip,
    //        "user_agent" => $user_useragent,
    //        "view_date" => (new \DateTime())->format('Y-m-d H:i:s'),
    //        "page_url" => $user_url,
    //    ]);
    
    //For highload purpose replace insertion with new case:
    $c = new \HSPHP\WriteSocket();
    $c->connect('localhost',9999);
    $id = $c->getIndexId('infohits', 'web_counter', '', 'views_count,ip_address,user_agent,view_date,page_url');
    $c->insert($id,array(1, $user_ip, $user_useragent, (new \DateTime())->format('Y-m-d H:i:s'), $user_url));
    $response = $c->readResponse(); //return array() if OK
}

if (defined('WEB_DEBUG') && WEB_DEBUG) {
    echo $user_ip . PHP_EOL;
    echo $user_url . PHP_EOL;
    echo $user_useragent . PHP_EOL;
    var_dump($datas);
} else {
    $im = imagecreatefrompng("banner.png");
    header('Content-Type: image/png');
    imagepng($im, NULL, 9);
    imagedestroy($im);   
}