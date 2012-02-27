<?php
class ApiDataSource extends DataSource
{
	private function httpRequest($url, $post=array()) {
		$ch = curl_init();
		//Change the user agent below suitably
		curl_setopt($ch, CURLOPT_USERAGENT, 'PageStatsTool/1.0');
		curl_setopt($ch, CURLOPT_URL, ($url));
		curl_setopt( $ch, CURLOPT_ENCODING, "UTF-8" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, "cookiejar");
		curl_setopt ($ch, CURLOPT_COOKIEJAR, "cookiejar");
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Expect:' ) );
		if (!empty($post))
		{
			$post["format"] = "php";
			curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
		}
		$xml = curl_exec($ch);
		if (!$xml) {
			throw new Exception("Error getting data from server ($url): " . curl_error($ch));
		}

		curl_close($ch);
		//echo $xml;
		return unserialize($xml);
	}

	protected function initialise()
	{
		$api = $this->location;
	
		$apiresult = $this->httpRequest($api, array(
			"action" => "query",
			"meta" => "userinfo"
			));
			
		try{
			if($apiresult['query']['userinfo']['id'] == 0)
			{
				$apiresult = $this->httpRequest($api, array(
					"action" => "login",
					"lgname" => $this->username,
					"lgpassword" => $this->password,
					"lgdomain" => $this->domain,
					));
				if($apiresult["login"]["result"] != "NeedToken")
					throw new LoginFailedException("Login result: " . print_r($apiresult,true));
					
				$apiresult = $this->httpRequest($api, array(
					"action" => "login",
					"lgname" => $this->username,
					"lgpassword" => $this->password,
					"lgdomain" => $this->domain,
					"lgtoken" => $apiresult["login"]["token"],
					));
				if($apiresult["login"]["result"] != "Success")
					throw new LoginFailedException("Login result: " . print_r($apiresult,true));
			}
		}
		catch(LoginFailedException $ex)
		{
			global $errors;
			$errors[] = "Unable to log into requested API with default credentials. I shall continue logged-out, young shirelings!";
		}
		
		$apiresult = $this->httpRequest($api, array(
			"action" => "query",
			"meta" => "siteinfo"
			));
			
		$this->siteinfo = $apiresult['query']['general'];
	}

	public $siteinfo;
	
	public function getNamespaces()
	{
		$api = $this->location;
	
		$apiresult = $this->httpRequest($api, array(
			"action"=>"query",
			"meta"=>"siteinfo",
			"siprop"=>"namespaces",
			));
			
		$apiresult = $apiresult["query"]["namespaces"];
		$result=array();
		foreach($apiresult as $ns)
		{
			if($ns['id'] < 0) continue;
			if($ns['id'] == 0)
			{
				$result[0] = "(Main)";
				continue;
			}
			$result[$ns['id']] = $ns['*'];
		}
		
		return $result;
	}
	
	public function getData($namespace, $page)
	{
		
	}
}