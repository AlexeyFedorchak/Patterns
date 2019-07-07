<?php
/**
	* This file devoted to the amazing PHP pattern ***ChainOfResponsibility***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	* 
	* The idea is to create different chains of middlewares. 
	* It is useful during authentication.
	*
*/

//declare namespace
namespace Index\ChainOfResponsibility;

//use another classes helpers
use Index\Builder\queryBuilder as Builder;
use Index\Builder\Query as MySQLQuery;
use Index\Singleton\MySQL as DBSettings;

/**
* interface for middleware types
*/
interface Middleware
{
	/**
	*	set next middleware
	*
	*	@param Middleware
	*   @return Middleware
	*/
	public function setNext(Middleware $instance) : Middleware;

	/**
	*	check if user go pass middleware
	*/
	public function check() : bool
}

abstract class AbstractMiddleware implements Middleware
{
	/**
	*	next middleware, will be set after this middleware
	*/
	protected $nextMiddleware;

	/**
	*	set next middleware
	*
	*	@param Middleware
	*   @return Middleware
	*/
	public function setNext(Middleware $instance) : Middleware 
	{
		$this->nextMiddleware = $instance;
		return $this->nextMiddleware;
	}

	/**
	*	check if user go pass middleware
	*	
	*	@return bool
	*	@param User
	*/
	abstract public function check(User $user) : bool
}

/**
*	Auth Middleware, check if user is in DB
*/
class authMiddleware extends AbstractMiddleware
{
	/**
	*	db settings, object of type MySQL
	*/
	protected $dbSettings;

	//init mysql connection settings
	public function __construct()
	{
		$dbSettings = MySQL::getInstance();
		$dbSettings->setSettings([
			"user" 		=> "Alex",
			"server" 	=> "127.0.0.1",
			"password" 	=> "5555"
		]);
	}

	/**
	*	check if user is in DB
	*	
	*	@param Users
	*	@return bool
	*/
	public function Check(Users $user) : bool
	{
		//make query to check if user is registered
		$mysqlQuery = queryBuilder::set("users")
	      ->where("id", "=", $user->id())
	      ->limit(1)
	      ->get();

		//get connection settings
	    $mysqlConnectionSettings = $dbSettings->getSettings();  

	    //make connection to db
	    $dbConnection = mysqli_connect (
	    	$mysqlConnectionSettings['server'],
	    	$mysqlConnectionSettings['user'],
	    	$mysqlConnectionSettings['password']);

	    //check if user is in db
	    if (mysqli_num_rows(mysqli_query($dbConnection, $mysqlQuery)) > 0) {
	    	$this->nextMiddleware->check();
	    } 

	    //return false if user is not found
	    return false;
	}
}

/**
*	Role Middleware
*	check if user has specified role
*/
class RoleMiddleware extends AbstractMiddleware
{
	/**
	*	user role, that should be checked
	*	@type string
	*/
	protected $role;

	/**
	*	set role to be checked
	*
	*	@param $role
	*/
	public function __construct(String $role)
	{
		$this->role = $role;
	}

	/**
	*	check if user has specified role
	*
	*	@param User
	*	@return bool
	*/
	public function check (User $user) : bool
	{
		if ($user->role() === $this->role) {
			$this->nextMiddleware->check();
		}

		return false;
	}
}

/**
*	custom class User, need to set for testing middleware
*/
class User
{
	/**
	*	unique id of user
	*/
	protected $id;

	/**
	*	user's role
	*/
	protected $role;

	/**
	*	user's name
	*/
	protected $name;

	/**
	*	set user attributes
	*	
	*	@param int 
	*	@param string 
	*	@param string 
	*/
	public function __construct (int $id, String $role, String $name)
	{
		$this->id = $id;
		$this->role = $role;
		$this->name = $name;
	}

	/**
	*	get id of user
	*/
	public function id()
	{
		return $this->id;
	}

	/**
	*	get name of user
	*/
	public function name()
	{
		return $this->name;
	}

	/**
	*	get role of user
	*/
	public function role()
	{
		return $this->role;
	}
}

/**
*
*	*** ===CLIENT'S CODE=== ***
*
*/
$userAdmin = new User(1, 'admin', 'Vanya');
$userGuest = new User(2, 'guest', 'Petro');
$userTeacher = new User(3, 'teacher', 'Vitaliy');
$userPaidUser = new User(4, 'paid_user', 'Palanka');

$authMiddleware = new authMiddleware();
$roleMiddlewareAdmin = new roleMiddleware('admin');
$roleMiddlewareTeacher = new roleMiddleware('teacher');
$roleMiddlewarePaidUser = new roleMiddleware('paid_user');

$authMiddleware
	->setNext($roleMiddlewarePaidUser)
	->setNext($roleMiddlewareTeacher)
	->setNext($roleMiddlewareAdmin);


/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */