<?php
/**
	* This file devoted to the amazing PHP pattern ***Prototype***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net
	* example: author and books. after clone a book, author should refere to the two books.
	*
*/

//declare namespace
namespace Index\Prototype;

//Prototype
class Book 
{
	private $title;
	private $author;
	private $publisher;

	public function __construct($title, Publisher $publisher, Author $author) 
	{
		$this->title = $title;
		$this->publisher = $publisher;
		$this->author = $author;

		//add author to book
		$this->author->addToBook($this);

		//add publisher to book
		$this->publisher->addToBook($this);
	}

	public function __clone() 
	{
		$this->title = "Copy of " . $this->title;

		//add author to cloned book
		$this->author->addToBook($this);

		//add publisher to cloned book
		$this->publisher->addToBook($this);
	}

	public function getAuthor() 
	{
		return $this->author->getName();
	}

	public function getPublisher() 
	{
		return $this->publisher->getName();
	}

	public function getName() 
	{
		return $this->title;
	}
}

class Author 
{
	private $name;
	private $books = array();

	public function __construct($name) 
	{
		$this->name = $name;
	}

	public function addToBook(Book $book) 
	{
		$this->books[] = $book;
	}

	public function getName() 
	{
		return $this->name;
	}

	public function getBooks() 
	{
		$booksNames = array();
		foreach ($this->books as $book) {
			$booksNames[] = $book->getName();
		}
		return implode(", ", $booksNames);
	}
}


class Publisher 
{
	private $name;
	private $books = array();

	public function __construct($name) 
	{
		$this->name = $name;
	}

	public function addToBook(Book $book) 
	{
		$this->books[] = $book;
	}

	public function getName() 
	{
		return $this->name;
	}

	public function getBooks() 
	{
		$booksNames = array();
		foreach ($this->books as $book) {
			$booksNames[] = $book->getName();
		}
		return implode(", ", $booksNames);
	}
}

//client code
$author 	= new Author("J. Keruak");
$publisher 	= new Publisher("Folio");
$book 		= new Book("Doroga", $publisher, $author);
$copyBook 	= clone $book;

echo "--------Prototype---------\r\n";
var_dump($book->getAuthor());
var_dump($book->getPublisher());
echo "--------CopyPrototype---------\r\n";
var_dump($copyBook->getAuthor());
var_dump($copyBook->getPublisher());

var_dump($author->getBooks());
var_dump($publisher->getBooks());


/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
