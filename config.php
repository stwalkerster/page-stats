<?php

$activeDataSource = "api";
$username = "";
$password = "";
$domain = ""; // LDAP domain, or db server hostname
$location = "http://en.wikipedia.org/w/api.php"; // API url, or Database Name





////////////////////////////////////////////////////////////////////////////////
if(file_exists("config.local.php")){include_once("config.local.php");}