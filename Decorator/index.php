<?php
/**
	* This file devoted to the amazing PHP pattern ***Decorator***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\Decorator;

/**
*
*	Main idea of an example is the task of including different styles files
*	depends on what page is loading, mobile|PC or what browser user uses.
*   <link href="css_file.css" rel="stylesheet" type="text/css" media="all">
*/

/**
*
*	Set main interface for all classes in the pattern
*
*
*/

interface Style
{
	public function setStyles () : String;
}


/**
*
*	Set default way to connect css to html
*
*/

class DefaultConnector implements Style
{
	protected $includingCssLink;

	public function __construct ()
	{
		$this->includingCssLink = '<link href="css_file.css" rel="stylesheet" type="text/css" media="all">';
	}

	public function setStyles () : String
	{
		return $this->includingCssLink;
	}
}



/**
*
*	Set base class for css files
*
*/

class BaseCss implements Style
{
	protected $connector;
	protected $file = "default_css.css";

	public function __construct (Style $style) 
	{
		$this->connector = $style;
	}

	public function setFile (String $file) 
	{
		$this->file = $file;
	}

	public function getFile () 
	{
		return $this->file;
	}

	public function setStyles () : String
	{
		return str_replace('css_file.css', $this->file, $this->connector->setStyles());
	}
}


/**
*
*	set default child for css class
*
*/

class DefaultCss extends BaseCss
{
	public function setStyles () : String
	{
		return parent::setStyles();
	}
}


/**
*
*	Client's code
*
*/

function setStyles(Style $style)
{
	echo $style->setStyles();
	echo "\r\n";
}

//using the code...
setStyles(new DefaultCss(new DefaultConnector()));

$anotherCss = new DefaultCss(new DefaultConnector());
$anotherCss->setFile('another_css.css');

setStyles($anotherCss);



/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */