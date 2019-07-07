<?php
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
* We have two types of books - Electronical and Paper.
* We may create a book based of the type of creator. 
* We may do it without "if"!
*/

//main creator
abstract class Creator
{
    public function factoryMethod (): Book {}
    public function describe (): String
    {
        $instance = $this->factoryMethod();
        $instance->describeSelf();
    }
}

class electronicalBookCreator extends Creator
{
    public function factoryMethod (): Book
    {
        return new electronicalBook();
    }
}

class paperBookCreator extends Creator
{
    public function factoryMethod (): Book
    {
        return new paperBook();
    }
}

interface Book
{
    public function describeSelf (): String;
}

class electronicalBook implements Book
{
    public function describeSelf(): String
    {
        return "I'm electronical book!\r\n";
    }
}

class paperBook implements Book
{
    public function describeSelf(): String
    {
        return "I'm paper book!\r\n";
    }
}



function bookTalks (Creator $creator)
{
    return $creator->factoryMethod()->describeSelf();
}

echo bookTalks(new paperBookCreator());
echo bookTalks(new electronicalBookCreator());


/**
* The end! Thanks for any comments. Hope you've enjoyed it.
* If something is incorrect. Please get in touch with me and tell me what is wrong.
*
*
*/