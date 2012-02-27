<?php
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