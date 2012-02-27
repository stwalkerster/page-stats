<?php
require_once("config.php");
if(file_exists("config.local.php")){include_once("config.local.php");}

require_once("languages.php");

spl_autoload_extensions(".php");
spl_autoload_register();

$availabledatasources = array(
	"db" => array(
		"class" => "DatabaseDataSource",
		),
	"api" => array(
		"class" => "ApiDataSource",
		),
	);
	
$dsconfig = $availabledatasources[$activeDataSource];

