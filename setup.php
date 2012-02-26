<?php

$availabledatasources = array(
	"db" => array(
		"class" => "DatabaseDataSource",
		),
	"api" => array(
		"class" => "ApiDataSource",
		),
	);
	
$dsconfig = $availabledatasources[$activeDataSource];

spl_autoload_extensions(".php");
spl_autoload_register();
