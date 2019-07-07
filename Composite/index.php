<?php
/**
	* This file devoted to the amazing PHP pattern ***Composite***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Composite;

/**
*
*	Composite is a main class that consists of main features.
*	It should be user only as a main class for another special
*
*
*/

class Composite
{
	protected $parent;
	protected $children;

	public function getParent()
	{
		return $this->parent;
	}

	public function setParent(Composite $composite)
	{
		$this->parent = $composite;
	}

	public function getChildren()
	{
		return $this->children;
	}

	public function add(Composite $composite)
	{
		$this->children[] = $composite;
	}

	public function remove(Composite $composite)
	{
		$this->children = array_filter($this->children, function ($child) use ($composite) {
			return $child !== $composite;
		});
	}
}


/**
*	
*	Specific class that uses features of Composite
*
*/

class Category extends Composite 
{	
	protected $name;

	public function getName()
	{
		return $this->name;
	}

	public function setName(String $name)
	{
		$this->name = $name;
	}
}


/**
*
*	Client's code.
*	Main is Books, that consists of e-books and paper books
*	The code is tested by using 'another test category'.
*
*/
$books = new Category();
$eBook = new Category();
$paperBook = new Category();

$books->setName('Fantasy');
$eBook->setName('E-book');
$paperBook->setName('Paper book');

$books->add($eBook);
$books->add($paperBook);

echo "\r\n" . 'Results without test category';
foreach ($books->getChildren() as $child) 
	echo "\r\n" . $child->getName();

$anotherBook = new Category();
$anotherBook->setName('Test another book');

$books->add($anotherBook);

echo "\r\n" . 'Results with test category';
foreach ($books->getChildren() as $child) 
	echo "\r\n" . $child->getName();

$books->remove($anotherBook);

echo "\r\n" . 'Results after remove the test category';
foreach ($books->getChildren() as $child) 
	echo "\r\n" . $child->getName();

/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
