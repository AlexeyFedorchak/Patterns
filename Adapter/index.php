<?php
/**
	* This file devoted to the amazing PHP pattern ***Adapter***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net
	* 
	*
*/

//declare namespace
namespace Index\Adapter;

//input the code here...



/*
* Interface for Messages
* 
* 
*/

interface Message
{
	public function getMessage ()	: String;
	public function getNickName()	: String;
	public function getChannel ()	: String;
	public function getAdapter ()	: Adapter;

	public function setMessage ( String $message ) 	: String;
	public function setNickName( String $nickName) 	: String;
	public function setChannel ( String $channel )		: String;
	public function setAdapter ( Adapter $adapter)	: Adapter;
	
}


/*
* Class Greeting with default greeting
* Interface - Message
* 
*/

class Greeting implements Message
{
	protected 	$message2;
	protected 	$nickName;
	protected 	$channel;
	public 		$defaultMessage;
	public 		$adapter;

	public function __construct 	() 
	{
		$this->defaultMessage = "Hello everybody!";
	}

	public function setMessage 		( String $message ) : String
	{
		return $this->message = $message;
	}

	public function setNickName 	( String $nickName ) : String
	{
		return $this->nickName = $nickName;
	}

	public function getMessage 		() : String
	{
		return $this->message;
	}

		public function getNickName () : String
	{
		return $this->nickName;
	}

	public function setChannel      ( String $channel ) : String
	{
		return $this->channel = $channel;
	}

	public function getChannel 		() : String
	{
		return $this->channel;
	}

	public function setAdapter 		( Adapter $adapter ) : Adapter
	{
		return $this->adapter = $adapter;
	}
	public function getAdapter 		() : Adapter
	{
		return $this->adapter;	
	}
}

/*
* Here will be another classes of Messages
* 
* 
*/
//==========================================
/*
* Interface for adapters
*
*/


interface Adapter
{
	public function setCurlUrl      ( String $curlUrl   )								: String;
	public function setCurlToken    ( String $curlToken )								: String;
	public function setCurlMessanger( CurlMessanger $curlMessanger, Message $message )	: CurlMessanger;

	public function getCurlUrl 	 	()		: String;
	public function getCurlToken 	()		: String;
	public function getCurlMessanger()		: CurlMessanger;
}


/*
* Function for Slack Adapter
* 
* 
*/

class SlackAdapter implements Adapter
{
	protected $curlUrl;
	protected $curlToken;
	protected $curlMessanger;

	public function setCurlUrl   	 ( String $curlUrl ) : String
	{
		return $this->curlUrl = $curlUrl;
	}

	public function setCurlToken     ( String $curlToken ) : String
	{
		return $this->curlToken = $curlToken;
	}

	public function getCurlUrl		 () : String
	{
		return $this->curlUrl;
	}

	public function getCurlToken     () : String
	{
		return $this->curlToken;
	}

	public function setCurlMessanger ( CurlMessanger $curlMessanger, Message $message ) : CurlMessanger
	{
		$this->curlMessanger = $curlMessanger;

		$this->curlMessanger->configMessenger
			([
				"token" 	=> $this 	 ->getCurlToken(),
				"curlUrl" 	=> $this 	 ->getCurlUrl(),
				"channel" 	=> $message ->getChannel(),
				"message" 	=> $message  ->getMessage(),
				"nickName" 	=> $message  ->getNickName(),
			]);

		return $this->curlMessanger;
	}

	public function getCurlMessanger  () : CurlMessanger
	{
		return $this->curlMessanger;
	}
}

/*
* Here will be another classes of Messages
* 
* 
*/

//===============================================
/*
* Interface for curlIgnitors
* 
* 
*/

interface CurlMessanger
{
	public function configMessenger     ( Array $args ) : Array;

	public function saySomething		() : String;
	public function getMessangerParams	() : Array;
}
/*
* One of the curl Messangers
* 
*/
class SlackCurlMessanger implements curlMessanger
{
	protected $args;

	public function configMessenger    ( Array $args ) : Array
	{
		return $this->args = $args;
	}

	public function getMessangerParams () : Array
	{
		return $this->args;
	}

	public function saySomething       () : String
	{
		$ch 	= curl_init ( $this->args['curlUrl'] );
	    $data 	= http_build_query
	    ([
	        'token' 	=> $this->args['token'],
	    	'channel' 	=> $this->args['channel'], 
	    	'text' 		=> $this->args['message'], 
	    	'username' 	=> $this->args['nickName'],
	    ]);
	    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
	    curl_setopt( $ch, CURLOPT_POSTFIELDS, 	  $data );
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true  );
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	    $result = curl_exec($ch);
	    curl_close ( $ch );
	    
	    return $result;
	}	
}
/*
* Here will be another classes of CurlMessangers
* 
* 
*/

//=================================================
//-------------------------------------------------
//************* ||  CLIENTS CODE ||  **************
//-------------------------------------------------
//=================================================

function doAction(

	Message $message, 
	Adapter $adapter, 
	CurlMessanger $curlMessanger, 
	Array $args

	) {
		$message->setMessage 	  ( $args['message']  );
		$message->setNickName 	  ( $args['nickName'] );
		$message->setChannel 	  ( $args['channel']  );

		$adapter->setCurlUrl 	  ( $args['curlUrl']  );
		$adapter->setCurlToken    ( $args['curlToken']);

		//Another parametrs should be set! Depends on what api we use!

		$adapter->setCurlMessanger( $curlMessanger, $message );

		$message->setAdapter      ( $adapter );

		$message->getAdapter      ()
				->getCurlMessanger()
				->saySomething    ();
	}


//init message!!!
doAction(

		 new Greeting(), 
		 new SlackAdapter, 
		 new SlackCurlMessanger, 

		 	[
				'message' 	=> 'Hey guys wanna study my soul?!...',
				'nickName' 	=> '#TestBot',
				'channel' 	=> '#smoking-club',
				'curlUrl' 	=> 'https://slack.com/api/chat.postMessage',
				'curlToken'	=> 'xoxp-288501502215-428560878450-459350819845-6ae5a4487364f860549c8df4027a08ed'
			]
		);






/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
