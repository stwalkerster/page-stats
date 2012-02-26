<?php
abstract class DataSource
{
	public function __construct($username, $password, $domain, $location)
	{
		$this->username = $username;
		$this->password = $password;
		$this->domain = $domain;
		$this->location = $location;
	}
	
	protected $username;
	protected $password;
	protected $domain;
	protected $location;

	/**
	 *	Gets the data for the specified page in the format:
	 *
	 *	Array( 
	 *		revId => Array( 
	 *			"timestamp" => timestamp,
	 *			"size" => size,
	 *			"user" => username
	 *		)
	 *	)
	 */
	public abstract function getData($namespace, $page);
	
	/**
	 *	Get an associative array of namespace IDs to namespace names
	 */
	public abstract function getNamespaces();
}