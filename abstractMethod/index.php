<?
/**
	* This file devoted to the amazing PHP pattern ***Abstract Factory***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net
	* Example: German|electro car <-> USA|petrol car
	*
*/

//declare namespace
namespace Index\abstractFactory;

//abastract factory
interface Factory 
{
	public function createElectroCar (): ElectroCar;
	public function createPetrolCar (): PetrolCar;
}

//USA factory
class USAFactory implements Factory 
{
	public function createElectroCar (): ElectroCar 
	{
		return new USAElectroCar();
	}

	public function createPetrolCar (): PetrolCar 
	{
		return new USAPetrolCar();
	}
}

//German factory
class GermanFactory implements Factory 
{
	public function createElectroCar (): ElectroCar  
	{
		return new GermanElectroCar();
	}

	public function createPetrolCar (): PetrolCar 
	{
		return new GermanPetrolCar();
	}
}



/**
 * description of ***PETROL CARS***
 */


//Abstract Petrol Car
interface PetrolCar 
{
	public function maxSpeed ();
}

//description of USA electro car
class USAPetrolCar implements PetrolCar
{
	protected $maxSpeed = 200;

	public function maxSpeed ()
	{
		return $this->maxSpeed;
	}
}

//description of USA petrol car
class GermanPetrolCar implements PetrolCar
{
	protected $maxSpeed = 250;

	public function maxSpeed ()
	{
		return $this->maxSpeed;
	}
}



/**
 * description of ***ELECTRO CARS***
 */


//Abstract Electro Car
interface ElectroCar 
{
	public function maxSpeed ();
}

//description of USA electro car
class USAElectroCar implements ElectroCar
{
	protected $maxSpeed = 300;

	public function maxSpeed ()
	{
		return $this->maxSpeed;
	}
}

//description of German electro car
class GermanElectroCar implements ElectroCar
{
	protected $maxSpeed = 350;

	public function maxSpeed ()
	{
		return $this->maxSpeed;
	}
}


/**
 *    ***CLIENT'S CODE***
 */


function getMaxSpeed(Factory $factory) 
{
	$electroCar = $factory->createElectroCar();
	$petrolCar = $factory->createPetrolCar();

	return "Electro: " . $electroCar->maxSpeed() . " | Petrol: " . $petrolCar->maxSpeed() . "<br>";
}

echo getMaxSpeed(new USAFactory());
echo getMaxSpeed(new GermanFactory());

/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */