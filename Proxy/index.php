<?php
/**
	* This file devoted to the amazing PHP pattern ***Proxy***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Proxy;

/**
*
*	The idea is to create a message class, that containts message content and messanger
*	And a substitute class, that trying to send the message if main messanger fail
*
*
*/

/**
*
*	Main interface
*
*/
interface Messanger
{
	public function sendMessage();
}

class InformBoss implements Messanger
{
	protected $message;

	public function __construct (String $message)
	{
		$this->message = $message;
	}

	public function sendMessage()
	{
		return 'The boss says: the message "' . $this->message . '" has been send!';	
	}
}

class InformSubstitute implements Messanger
{
	protected $boss;
	
	public function __construct (InformBoss $boss)
	{
		$this->boss = $boss;
	}

	public function sendMessage()
	{
		return 'Substitute say bahalf the boss: ' . $this->boss->sendMessage();
	}
}


$boss = new InformBoss('Hi!');
echo $boss->sendMessage() . "\r\n";

$sub = new InformSubstitute($boss);
echo $sub->sendMessage() . "\r\n";



/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
