<?php
/**
	* This file devoted to the amazing PHP pattern ***Command***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Command;

/**
*
*	Inteface for classes UnitCommand and ComplexCommand
*
*/
interface Command
{
	public function execute() : void;
}

/**
*	Class for simple command
*/
class UnitCommand implements Command
{
	/**
	*	String: contains command
	*/
	protected $command;

	/**
	*	Init class and set command
	*/
	public function __construct(String $command)
	{
		$this->command = $command;
	}

	/**
	*	execute command
	*	in real example here may be shell_exec
	*/
	public function execute() : void
	{
		echo $this->command . "\r\n";
	}
}

/**
*	Complex class of Command type
*/
class ComplexCommand implements Command
{
	/**
	*	object of type Receiver
	*	contains list of commands
	*/
	protected $receiver;

	/**
	*	init class
	*	set receiver
	*/
	public function __construct(Receiver $receiver)
	{
		$this->receiver = $receiver;
	}

	/**
	*	execute all the commands set above
	*/
	public function execute() : void
	{
		$this->receiver->run();
	}
}

/**
*	Class Receiver
*	contains list of comands
*/
class Receiver
{
	/**
	*	Array of string | in real example it may contain list of UnitCommands
	*/
	protected $commands;

	/**
	*	Init obect of this type
	*	set list of commands
	*/
	public function __construct(Array $commands)
	{
		$this->commands = $commands;
	}

	/**
	*	run commands
	*/
	public function run()
	{
		foreach ($this->commands as $command) {
			echo $command . "\r\n";;
		}
	}
}

/**
*	Class Invoker
*	manage running of commands
*/
class Invoker
{
	/**
	*	Array: list of commands (Type of specific command = Commands)
	*/
	protected $commands = [];

	/**
	*	adding specific command to invoker
	*	just another way to add commands ito the system | above it was done by using __construct
	*/
	public function add(Command $command)
	{
		if (array_search($command, $this->commands) === FALSE) {
			$this->commands[] = $command;
		}
		return $this;
	}

	/**
	*	execute all the commands
	*	also we may create specific execution methods
	*/
	public function run()
	{
		foreach ($this->commands as $command) {
			$command->execute();
		}
	}
}

	/**
	*
	*		CLIENT'S CODE
	*
	*/
	
	$gulp = new UnitCommand('./gulp');
	$git = new ComplexCommand(new Receiver(['git fetch', 'git pull']));

	$invoker = new Invoker();
	$invoker->add($git)
		->add($gulp);

	$invoker->run();



/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
