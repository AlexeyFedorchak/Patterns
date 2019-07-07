<?
/**
* FactoryMethod Ver 0.1
* This is doc of Oleksiy Fedorchak. Feel free to use it.
* e-mail: atilla3@ukr.net
*/

//declare namespace
namespace Index\factoryMethod;

/**
* The main point is to create two groups of classes - creators and products.
* It helps to create flexible structure for your application
*
* The pattern is presented below on the example of books.
* We have two types of books - Fantasy and Science.
*/


//Main creator
abstract class createBook
{
    //Factory method
    public function createBook(String $name, String $author, String $publisher)
    {

    }
}

//Childs creators: Fantasy Book Creator and Science Book Creator
class createFantasyBook extends createBook
{
    //Factory method
    public function createBook(String $name, String $author, String $publisher)
    {
        return fantasyBook::createInstance($name, $author, $publisher);
    }
}

class createScienceBook extends createBook
{
    //Factory method
    public function createBook(String $name, String $author, String $publisher)
    {
        return scienceBook::createInstance($name, $author, $publisher);
    }
}

//Some another creators...


//Products inteface. Also eare we may use abstract class.
//It may help to avoid duplicates.
interface Book
{
    //some example of methods
    public function tellAboutSelf(): String;
    public function getName();
    public function getAuthor();
    public function getPublusher();
    public static function createInstance(String $name, String $author, String $publisher);
}

//Books classes
class fantasyBook implements Book
{
    //Some custom atributes. It should be protected.
    protected $name;
    protected $author;
    protected $publisher;

    //some another vaiables

    //init privvate constructor
    private function __construct (String $name, String $author, String $publisher)
    {
        $this->name = $name;
        $this->author = $author;
        $this->publisher = $publisher;
    }

    //Some custom methods
    public function tellAboutSelf(): String
    {
        return "Fantasy Book</br>";
    }

    //get protected value of name method
    public function getName()
    {
        return $this->name;
    }

    //get protected value of author method
    public function getAuthor()
    {
        return $this->author;
    }

    //get protected value of publisher method
    public function getPublusher()
    {
        return $this->publisher;
    }

    //Protected creating new instanse of self
    public static function createInstance(String $name, String $author, String $publisher)
    {
        return new self($name, $author, $publisher);
    }

    //some another methods...
}

class scienceBook implements Book
{
    //Some custom atributes. It should be protected.
    protected $name;
    protected $author;
    protected $publisher;

    //some another vaiables

    //init private constructor
    private function __construct (String $name, String $author, String $publisher)
    {
        $this->name = $name;
        $this->author = $author;
        $this->publisher = $publisher;
    }

    //Some custom methods
    public function tellAboutSelf(): String
    {
        return "Science Book</br>";
    }

    //get protected value of name method
    public function getName()
    {
        return $this->name;
    }

    //get protected value of author method
    public function getAuthor()
    {
        return $this->author;
    }

    //get protected value of publisher method
    public function getPublusher()
    {
        return $this->publisher;
    }

    //Protected creating new instanse of self
    public static function createInstance(String $name, String $author, String $publisher)
    {
        return new self($name, $author, $publisher);
    }

    //some another methods...
}


//Client code. Here is an example of using presented above classes sctructure
function doAction(createBook $creator, String $name, String $author, String $publisher)
{
    return $creator->createBook($name, $author, $publisher);
}

//create fantasy book "Harry Potter"
$harryPotter = doAction(new createFantasyBook, "Harry Potter", "J. Rowling", "A-Ba-Ha-La-Ma-Ga");

//create science book
$capital = doAction(new createScienceBook, "Capital", "K. Marx", "Moscow Publication Comunity");


echo $harryPotter->getName()
                  . " | "
                  . $harryPotter->getAuthor()
                  . " | "
                  . $harryPotter->getPublusher()
                  . "</br>";
echo $capital->getName()
                  . " | "
                  . $capital->getAuthor()
                  . " | "
                  . $capital->getPublusher()
                  . "</br>";


/**
* The end! Thanks for any comments. Hope you've enjoyed it.
* If something is incorrect. Please get in touch with me and tell me what is wrong.
*
*
*/
