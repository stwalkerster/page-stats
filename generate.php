<?php

$ds = new $dsconfig["class"] (
	$username, 
	$password, 
	$domain, 
	$_SESSION['api'] 
	);

$nslist = $ds->getNamespaces();

$page = ($_SESSION['ns'] == 0 ? "" : $nslist[$_SESSION['ns']] . ":") . $_SESSION['title'];

$smarty->assign("pagename", $page);
$smarty->assign("pagelink", $ds->siteinfo['server'] . str_replace('$1', $page , $ds->siteinfo['articlepath']));
