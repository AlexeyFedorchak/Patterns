<?php
/**
	* This file devoted to the amazing PHP pattern ***Flyweight***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Flyweight;

/**
*
*	FlyWeight
*	PHP Patterns
*	The main idea is: we have bike with model and speed attrributes
*	And we have the race of bikes with mutual attributes - circles, last and first bikes in the race
*	The task is do not copy value of mutual attributes
*
*/


/**
*
*	Class for special element with special attributes:
*	- speed
*	- model
*
*/

class Bike
{
	protected $model;
	protected $speed;

	public function __construct (String $model, int $speed)
	{
		$this->model = $model;
		$this->speed = $speed;
	}

	public function getSpeed () 
	{
		return $this->speed;
	}

	public function getModel () 
	{
		return $this->model;
	}
}


/**
*
*	Bike Factory: 
*	creates bikes of some model
*	with some speed
*
*/

class BikeFactory
{
	protected $bike;

	public function getBike (String $model, int $speed) : Bike
	{
		return new Bike ($model, $speed);
	}
}


/**
*
*	Creates array of Bikes
*	It is also comfortable to use this class
*	for getting getting special bike or array of the attributues
*
*/

class BikeCompetitors
{
	private $bikeFactory;
	private $bikeCompetitors;

	public function __construct (BikeFactory $bikeFactory)
	{
		$this->bikeFactory = $bikeFactory;
	}

	public function createCompetitors (Array $bikes)
	{
		foreach ($bikes as $bike) {
			$this->bikeCompetitors[] = $this->bikeFactory->getBike($bike['model'], $bike['speed']);
		}
	}

	public function getCompetitor (int $bikeIndex)
	{
		return $this->bikeCompetitors[$bikeIndex];
	}

	public function getCompetitorsSpeed ()
	{
		$speed = [];
		foreach ($this->bikeCompetitors as $key => $competitor) {
			$speed[$key] = $competitor->getSpeed();
		}
		return $speed;
	}
}


/**
*
*	And finally race class!
*	This class containts mutual attributes of all bikes.
*
*/

class Race
{
	private $bikeCompetitors;
	private $circles;
	private $first;
	private $last;

	public function __construct (BikeCompetitors $bikeCompetitors)
	{
		$this->bikeCompetitors = $bikeCompetitors;
	}

	public function setCircles (int $circles)
	{
		$this->circles = $circles;
	}

	public function setFirst (int $bikeIndex)
	{
		$this->first = $this->bikeCompetitors->getCompetitor($bikeIndex);
	}

	public function setLast (int $bikeIndex)
	{
		$this->last = $this->bikeCompetitors->getCompetitor($bikeIndex);
	}

	public function setLastBasedOnSpeed ()
	{
		$speed = $this->bikeCompetitors->getCompetitorsSpeed();

		return $this->setLast(
				array_search(min($speed), $speed)
			);
	}

	public function setFirstBasedOnSpeed ()
	{
		$speed = $this->bikeCompetitors->getCompetitorsSpeed();

		return $this->setFirst(
				array_search(max($speed), $speed)
			);	
	}
}



/**
*
*
*	Client's code
*
*
*/

//making competitors class
$competitors = new BikeCompetitors(new BikeFactory());

//creating bikes
$competitors->createCompetitors([
	[
		'model' => 'BMW',
		'speed' => 200
	],
	[
		'model' => 'Honda',
		'speed' => 188
	],
	[
		'model' => 'Suzuki',
		'speed' => 176
	],
	[
		'model' => 'Kawasaki',
		'speed' => 164
	],
	[
		'model' => 'Toyota',
		'speed' => 152
	],
	[
		'model' => 'Benneveli',
		'speed' => 140
	]
]);




//making race
$race = new Race($competitors);

//setting mutual attributes for bikes
$race->setCircles(2);
$race->setFirst(2);
$race->setLastBasedOnSpeed();
$race->setFirstBasedOnSpeed();

print_r($race);





/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
