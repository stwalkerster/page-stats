<?php
abstract class DataSource
{
	protected __construct()
	{
	
	}
	
	private static $instance;
	public static function getInstance()
	{
		if($instance == null)
		{ $instance = new get_called_class(); }
		return $instance;
	}
	
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
}