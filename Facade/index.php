<?php
/**
	* This file devoted to the amazing PHP pattern ***Facade***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Facade;

/**
*
*
*	The idea of an example is to work with database.
*	First you need to make the connection.
*	Next you need to make the query.
*	Finally, you need to fetch the data into the array or some collection.
*
*
*
*/

/**
*
*	The class Facade that consists the function which do all the actions
*
*/

class Facade
{
	protected $connector;
	protected $querySender;
	protected $fetcher;

	public function __construct 
	(
		DatabaseConnector $connector,
		QueryManager $querySender,
		FetchManager $fetcher
	)
	{
		$this->connector = $connector;
		$this->querySender = $querySender;
		$this->fetcher = $fetcher;
	}

	public function getData ()
	{
		$res = $this->connector->connect();
	
		return $this->fetcher->getData(
			$this->querySender->sendSelectQuery($res)
			);
	}
}



/**
*
*	The class for connection to database
*
*/

class DatabaseConnector
{
	protected $server;
	protected $user;
	protected $password;
	protected $dataBaseName;

	public function __construct
	(
		String $server,
		String $user,
		String $password,
		String $dataBaseName
	) 
	{
		$this->server = $server;
		$this->user = $user;
		$this->password = $password;
		$this->dataBaseName = $dataBaseName;
	}

	public function connect ()
	{
		$connector = mysqli_connect
		(
			$this->server, 
			$this->user, 
			$this->password,
			$this->dataBaseName
		);

		mysqli_set_charset($connector, 'utf8');

		return $connector;
	}
}


/**
*
*	Tha class for sending queries
*
*/

class QueryManager
{
	protected $table;

	public function __construct (String $table)
	{
		$this->table = $table;
	}

	public function sendSelectQuery ($res)
	{
		return mysqli_query($res, 'SELECT * FROM ' . $this->table);
	}
}


/**
*
*	The class for fetching data
*
*/

class FetchManager
{
	protected $dataFromDb;

	public function getData ($res)
	{
		while($data = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
			$this->dataFromDb[] = $data;
		}

		return $this->dataFromDb;
	}
}


/**
*
*	Client's code...
*
*/

$dbConnect = new DatabaseConnector
					(
						'127.0.0.1',
						'root',
						'',
						'miska_2'
					);

$querySender = new QueryManager('page');
$fetcher = new FetchManager();

$facade = new Facade($dbConnect, $querySender, $fetcher);
$data = $facade->getData();
print_r($data);


/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
