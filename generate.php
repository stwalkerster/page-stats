<?php

$ds = new $dsconfig["class"] (
	$username, 
	$password, 
	$domain, 
	$_SESSION['api'] 
	);

$nslist = $ds->getNamespaces();
	
$smarty->assign("pagename", $nslist[$_SESSION['ns']] . ":" . $_SESSION['title']);
$smarty->assign("api", $_SESSION['api']);
