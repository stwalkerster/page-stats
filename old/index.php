<?php 
require_once("setup.php");

session_start();

$ds = new $dsconfig["class"] (
	$username, 
	$password, 
	$domain, 
	isset($_SESSION['api']) ? $_SESSION['api'] : $location
	);


require("form.php");

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
{ // posted, do show whichever form is appropriate
	if(isset($_REQUEST['generate']) && $_REQUEST['generate'] == "yes")
	{// generate stats
	
	}
	else
	{
		if(isset($_REQUEST['from']) && $_REQUEST['from'] == 
	
		if(isset($_REQUEST['jump']))
		{
			$output = $wizHead . $wiz[$_REQUEST['jump']] . $wizFoot;
		}
		else
		{
			$output = $wizHead . $wiz[0] . $wizFoot;
		}
	}
}
else
{ // not posted, show first form
	$output = $wizHead . $wiz[0] . $wizFoot;
}

include("header.htmlfrag"); 
echo $output;
include("footer.htmlfrag");