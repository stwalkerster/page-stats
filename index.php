<?php
require_once("smarty/Smarty.class.php");
$smarty = new Smarty();
ini_set('display_errors',0);
include_once("config.php");
if(file_exists("config.local.php")){include_once("config.local.php");}
	
require_once("DataSource.php");
require_once("ApiDataSource.php");
require_once("DatabaseDataSource.php");
require_once("LoginFailedException.php");

$availabledatasources = array(
	"db" => array(
		"class" => "DatabaseDataSource",
		),
	"api" => array(
		"class" => "ApiDataSource",
		),
	);
	
$dsconfig = $availabledatasources[$activeDataSource];
session_start();

$smarty->assign("active", "nothing");

$errors = array();

if(isset($_REQUEST['wizard']))
{
	$wizardPage = $_REQUEST['wizard'];
	$smarty->assign("showHero", false);
	$smarty->assign("wizardPage", $wizardPage);
	
	switch($wizardPage)
	{
		case 1:
			handleWizard1();
			break;
		case 2:
			handleWizard2();
			break;
		case 3:
			handleWizard3();
			break;
		case 4:
			handleWizard4();
		default:
			break;
	}
	$smarty->assign("errors", $errors);
	$smarty->assign("active", "Wiz");
	$smarty->display("wizard.tpl");
}
else
{
	$smarty->assign("errors", $errors);
	if(isset($_REQUEST['action']))
	{
		if($_REQUEST['action'] == "generate")
		{
			require_once("generate.php");
			$smarty->assign("showHero", false);
			$smarty->display("report.tpl");
		}
		else
		{
			showMain($smarty);
		}
	}
	else
	{
		showMain($smarty);
	}
}

function showMain($smarty)
{
	$smarty->assign("active", "Home");
	$smarty->assign("showHero", true);
	$smarty->display("base.tpl");
}

function getWikimediaLanguages()
{
	$ch = curl_init();
	//Change the user agent below suitably
	curl_setopt($ch, CURLOPT_USERAGENT, 'PageStatsTool/1.0');
	curl_setopt($ch, CURLOPT_URL, ("http://en.wikipedia.org/w/api.php"));
	curl_setopt( $ch, CURLOPT_ENCODING, "UTF-8" );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, "cookiejar");
	curl_setopt ($ch, CURLOPT_COOKIEJAR, "cookiejar");
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Expect:' ) );
	$post = array(
		"action"=>"query",
		"meta"=>"siteinfo",
		"siprop"=>"interwikimap",
		"sifilteriw"=>"local",
		"format"=>"php"
		);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$post);

	$xml = curl_exec($ch);
	if (!$xml) {
		throw new Exception("Error getting data from server ($url): " . curl_error($ch));
	}
	curl_close($ch);
	$data = unserialize($xml);
	$data = $data['query']['interwikimap'];

	$languages = array();

	foreach($data as $lang)
	{
		if(isset($lang['language']))
		{
			if($lang['url'] == ("http://" . $lang['prefix'] . '.wikipedia.org/wiki/$1'))
			{
				$languages[] = $lang['prefix'];
			}
		}
	}

	return $languages;
}

function handleWizard3()
{
	global $smarty, $domains;
	$smarty->assign("wizProgress", 33);
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$apiUrl = $_REQUEST['api'];
		$_SESSION['api'] = $apiUrl;
		
		header("HTTP/1.1 303 See Other");
		header("Location: {$_SERVER["SCRIPT_NAME"]}?wizard=4");
	}
	else
	{
		$smarty->assign("wizardPageTemplate", "wiz3.tpl");
	}
}

function handleWizard2()
{
	global $smarty, $domains;
	
	$smarty->assign("wizProgress", 33);
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$apiUrl = "http://" . $_REQUEST['wmflanguage'] . "." . 
			$domains[$_SESSION['wmfdomain']] . "/w/api.php";
		$_SESSION['api'] = $apiUrl;
		
		header("HTTP/1.1 303 See Other");
		header("Location: {$_SERVER["SCRIPT_NAME"]}?wizard=4");
	}
	else
	{
		$smarty->assign("wmflangs", getWikimediaLanguages());
		$smarty->assign("rootdomain", $domains[$_SESSION['wmfdomain']]);
		$smarty->assign("wizardPageTemplate", "wiz2.tpl");
	}
}

function handleWizard4()
{
	global $smarty, $dsconfig, $ds, $username, $password, $domain, $errors;
	
	$smarty->assign("wizProgress", 66);
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_SESSION['ns'] = $_REQUEST['ns'];
		$_SESSION['title'] = $_REQUEST['title'];
		header("HTTP/1.1 303 See Other");
		header("Location: {$_SERVER["SCRIPT_NAME"]}?action=generate");
	}
	else
	{
		try
		{
			$ds = new $dsconfig["class"] (
				$username, 
				$password, 
				$domain, 
				$_SESSION['api'] 
				);
				
			$smarty->assign("namespaces", $ds->getNamespaces());
			$smarty->assign("sitename", $ds->siteinfo['sitename']);
			$smarty->assign("sitebase", $ds->siteinfo['base']);
			$smarty->assign("wizardPageTemplate", "wiz4.tpl");
		
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
			$smarty->assign("wizardPage", 1);
			handleWizard1();
		}
	}
}

function handleWizard1()
{

	global $smarty;
	$smarty->assign("wizProgress", 0);
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$nextPage=2;
		switch($_REQUEST['wmfdomain'])
		{
			case "pedia":
			case "wikt":
			case "quote":
			case "books":
			case "source":
			case "news":
			case "versity":
				$_SESSION['wmfdomain'] = $_REQUEST['wmfdomain'];
				$nextPage=2;
				break;
			////////////////////////////////////////////////////////////////////
			case "species":	
				$_SESSION['api'] = "http://species.wikimedia.org/w/api.php";
				$nextPage=4;
				break;
			case "commons":
				$_SESSION['api'] = "http://commons.wikimedia.org/w/api.php";
				$nextPage=4;
				break;
			case "mw":
				$_SESSION['api'] = "http://www.mediawiki.org/w/api.php";
				$nextPage=4;
				break;
			case "meta":
				$_SESSION['api'] = "http://meta.wikimedia.org/w/api.php";
				$nextPage=4;
				break;
			case "ts":
				$_SESSION['api'] = "https://wiki.toolserver.org/w/api.php";
				$nextPage=4;
				break;
			////////////////////////////////////////////////////////////////////
			case "other":
				$nextPage=3;
				break;
			////////////////////////////////////////////////////////////////////
			default: die(); break;
		}
		
		header("HTTP/1.1 303 See Other");
		header("Location: {$_SERVER["SCRIPT_NAME"]}?wizard={$nextPage}");
		
	}
	else
	{
		$smarty->assign("wizardPageTemplate", "wiz1.tpl");
	}
}