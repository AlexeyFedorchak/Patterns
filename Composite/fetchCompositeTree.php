<?php
/**
*
*	**  this example has a goal to fetch the data from composite in one array
*	**	author: OleXii (atilla3@ukr.net)
*
*
*/

class Tree
{
	protected $name;
	protected $branches;
	protected $storage;
	protected $parent;

	public function __construct (String $name, Storage $storage)
	{
		$this->name = $name;
		$this->storage = $storage;
	}

	public function setChild (Branch $branch)
	{
		$this->branches[] = $branch;
		$branch->setParent($this);
	}

	public function setParent (Tree $parent) 
	{
		$this->parent = $parent;
	}

	public function getParent ()
	{
		return $this->parent;
	}

	public function isComposite () 
	{
		return count($this->branches) > 0;
	}

	public function askChildren () 
	{
		foreach ($this->branches as $branch) {
			$branch->getName();
		}
	}

	public function name() 
	{
		return $this->name;
	}

	public function __call ($name, $arguments)
	{
		//make name comfortable for using
		$name = strtolower($name);

		//case getName | GetName | getname
		if (strpos($name, 'get') !== FALSE && strpos($name, 'name') !== FALSE) {
			$this->storage->addData($this);
			if ($this->isComposite()) {
				$this->askChildren();
			}
		}
	}
}

//for comfortable using tree and saving logic
class Branch extends Tree {}

//for symplifying saving data process
class Storage
{
	protected $data;

	public function addData (Tree $component)
	{
		$this->data[] = $component;
	}

	public function getData ()
	{
		return $this->data;
	}

	public function getWays ()
	{
		$componentWitoutChildren = [];

		//define components without children
		foreach ($this->data as $component) {
			if (!$component->isComposite()) {
				$componentWitoutChildren[] = $component;
			}
		}


		$parents = [];

		//recursively cycle for searching all possible ways to go through the tree
		foreach ($componentWitoutChildren as $component) {
			$parent = $component->getParent();
			while(!is_null($parent)) {
				$parent = $parent->getParent();
				if (!is_null($parent)) {
					$parents[$component->name()][] = $parent->name();
				} else {
					$parents[$component->name()][] = 'End';	
				}
			}
		}

		return $parents;
	}

	public function getShortestWay ()
	{
		$allWays = $this->getWays();
		$lenght = [];
		foreach ($allWays as $way) {
			$lenght[] = count($way);
		}

		$minLenght = min($lenght);

		$minWays = [];
		foreach ($allWays as $key => $way) {
			if (count($way) === $minLenght) {
				$wayDescription = $key;
				foreach ($way as $step) {
					$wayDescription .= '-' . $step;
				}
				$minWays[] = $wayDescription;
			}
		}

		$minWays['min-lenght'] = $minLenght + 1;

		return $minWays;
	}

	public function getLongestWay ()
	{
		$allWays = $this->getWays();
		$lenght = [];
		foreach ($allWays as $way) {
			$lenght[] = count($way);
		}

		$maxLenght = max($lenght);

		$maxWays = [];
		foreach ($allWays as $key => $way) {
			if (count($way) === $maxLenght) {
				$wayDescription = $key;
				foreach ($way as $step) {
					$wayDescription .= '-' . $step;
				}
				$maxWays[] = $wayDescription;
			}
		}

		$maxWays['max-lenght'] = $maxLenght + 1;

		return $maxWays;
	}
}


$storage = new Storage();
$tree = new Tree ('Tree', $storage);
$branch1 = new Branch ('Branch1', $storage);
$branch2 = new Branch ('Branch2', $storage);
$branch3 = new Branch ('Branch3', $storage);
$branch4 = new Branch ('Branch4', $storage);
$branch5 = new Branch ('Branch5', $storage);
$branch6 = new Branch ('Branch6', $storage);

$tree->setChild($branch1);
$tree->setChild($branch2);
$branch2->setChild($branch3);
$branch2->setChild($branch4);
$branch3->setChild($branch5);
$branch5->setChild($branch6);

$tree->getName();
$data = $storage->getData();
$ways = $storage->getWays();
$minWay = $storage->getShortestWay();
$maxWay = $storage->getLongestWay();

print_r($minWay);


/**
*
*	** when getName () is calling the __call intializing and 
*   ** recursively visit every component in the tree
*	** it gives an opportunity to go through all components
*	** explore them, find shortest and longest ways e.t.c
*
*/

?>