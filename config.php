<?php

$activeDataSource = "db";
$username = "";
$password = "";
$domain = ""; // LDAP domain, or db server hostname
$location = ""; // API url, or Database Name





////////////////////////////////////////////////////////////////////////////////
if(file_exists("config.local.php")){include_once("config.local.php");}