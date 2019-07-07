<?php
/**
	* This file devoted to the amazing PHP pattern ***Mist***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Mist;


//declare first class
class HtmlTag
{
	protected $color; 

	public function putContent(String $content)
	{
		$tags = $this->putColor();
		return $tags[0] . $content . $tags[1];
	}

	private function putColor()
	{
		$tags = $this->getHtmlTag();
		$tagsWithColor = substr($tags[0], 0, -1) 
		. ' style = "color: ' . $this->color->getColor() . ';"' 
		. substr($tags[0], -1);

		return [
			0 => $tagsWithColor,
			1 => $tags[1]
		];
	}

	public function __construct(Color $color)
	{
		$this->color = $color;
	}
}



// Custom tag <h1>

class H1 extends HtmlTag
{
	public function getHtmlTag()
	{
		return [
			0 => "<h1>",
			1 => "</h1>",
		];
	}
}


// Custom tag <h2>

class H2 extends HtmlTag
{
	public function getHtmlTag()
	{
		return [
			0 => "<h2>",
			1 => "</h2>",
		];
	}
}


// Custom tag <h3>

class H3 extends HtmlTag
{
	public function getHtmlTag()
	{
		return [
			0 => "<h3>",
			1 => "</h3>",
		];
	}
}




/**
* Interface for colors
* We may build another interfaces for another options by which
* we would like to complete the html tags
*
*/


interface Color
{
	public function getColor(): String;
}


//custom class for green color

class Green implements Color
{
	public function getColor() : String
	{
		return "green";
	}
}


//custom class for red color

class Red implements Color
{
	public function getColor() : String
	{
		return "red";
	}
}


//custom class for grey color

class Grey implements Color
{
	public function getColor() : String
	{
		return "grey";
	}
}


/**
*
*	CLIENT'S CODE
*
*
*/

function doAction(HtmlTag $htmlTag, String $content)
{
	return $htmlTag->putContent($content);
}



// Implementation of client's code

echo doAction(new H2(new Green()), "Hello from MIST") . "\r\n";

/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
