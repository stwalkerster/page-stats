<?php 
require_once("config.php");
require_once("setup.php");

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
{ // posted, do stats
	
}
else
{ // not posted, show form
	$output = file_get_contents("form.htmlfrag");
}

include("header.htmlfrag"); 
echo $output;
include("footer.htmlfrag");