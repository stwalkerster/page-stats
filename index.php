<?php
require_once("smarty/Smarty.class.php");
$smarty = new Smarty();

$domains = array(
	"pedia" => "wikipedia.org",
	"wikt" => "wiktionary.org",
	"quote" => "wikiquote.org",
	"books" => "wikibooks.org",
	"source" => "wikisource.org",
	"news" => "wikinews.org",
	"versity" => "wikiversity.org",
	);

session_start();

if(isset($_REQUEST['wizard']))
{
	$wizardPage = $_REQUEST['wizard'];
	$smarty->assign("showHero", false);
	$smarty->assign("wizardPage", $wizardPage);
	
	switch($wizardPage)
	{
		case 1:
			handleWizard1();
			$smarty->assign("wizProgress", 0);
			break;
		case 2:
			handleWizard2();
			$smarty->assign("wizProgress", 33);
			break;
		default:
			break;
	}
	$smarty->display("wizard.tpl");
}
else
{
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

function handleWizard2()
{
	global $smarty, $domains;
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
	
	}
	else
	{
		$smarty->assign("wmflangs", getWikimediaLanguages());
		$smarty->assign("rootdomain", $domains[$_SESSION['wmfdomain']]);
		$smarty->assign("wizardPageTemplate", "wiz2.tpl");
	}
}

function handleWizard1()
{
	global $smarty;
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