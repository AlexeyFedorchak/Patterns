<?php
/**
	* This file devoted to the amazing PHP pattern ***Singleton***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net
	* example: SQL settings (database server, user, password)
	* method setSettings - the sigle way to change SQL login data
	*
*/

//declare namespace
namespace Index\Singleton;



class MySQL 
{
	private static $instances = [];

	private $settings = [
		"user" => "root",
		"server" => "localhost",
		"password" => "1111"
	];

	protected function __construct () {}
	
	protected function __clone () {}
	
	public function __wakeup () 
	{
		throw new \Exception("Cannot unserialize the class with SQL settings!");
	}

	public static function getInstance(): MySQL
	{
		$instance = get_called_class();
		if (! isset(self::$instances[$instance])) {
			self::$instances[$instance] = new static;
		}

		return self::$instances[$instance];
	}

	public function getSettings() 
	{
		return $this->settings;
	}

	public function setSettings($settings)
	{
		$this->settings = $settings;
	}

}

$dataBase = MySQL::getInstance();
echo "After creating new instance: \r\n";
var_dump($dataBase->getSettings());

$dataBase->setSettings([
	"user" 		=> "Alex",
	"server" 	=> "127.0.0.1",
	"password" 	=> "5555"
]);

echo "After determine new settings: \r\n";
var_dump($dataBase->getSettings());

$newDataBase = MySQL::getInstance();
echo "After trying to create one new instance: \r\n";
var_dump($newDataBase->getSettings());

/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */