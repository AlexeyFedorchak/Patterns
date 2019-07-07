<?php
//config

//search parametrs
$search    = "link</a></p>";

//files parameters
$folder    = __DIR__ . "/" . $argv[1];
$filename  = __DIR__ . "/" . $argv[1] . "/index.php";

//setting greeting code
$startCode = "<?php
/**
	* This file devoted to the amazing PHP pattern ***" . $argv[1] . "***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net 
	* 
	*
*/

//declare namespace
namespace Index\\" . $argv[1] . ";

//input the code here...
echo 'Welcome!';





/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
";

//creating folder
if (!is_dir($folder)) {
    if (mkdir(__DIR__ . "/" . $argv[1])) {
    	echo " *** ПАПКУ СТВОРЕНО АБО ОНОВЛЕНО ІСНУЮЧУ! *** \r\n";
    } else {
    	die(" *** НЕ ВДАЛОСЬ СТВОРИТИ ПАПКУ! *** \r\n");
    }
} else {
	die(" *** ПЕРЕВІР ЧИ ПАТТЕРН ВЖЕ ІСНУЄ! *** \r\n");
}


//creating file
if ($make = fopen($filename, "w")) {
	fwrite($make, $startCode);
	echo " *** СЕРЕДОВИЩЕ ДЛЯ " . $argv[1] . " УСПІШНО СТВОРЕНО *** \r\n";
} else {
	die(" *** ПОМИЛКА ПІД ЧАС СТВОРЕННЯ ФАЙЛА:) *** ");
}

$indexContent = file_get_contents("index.php");

if (strpos($indexContent, $argv[1]) === FALSE) {
	$lastPosition = strripos($indexContent, $search);
	$lengthTotal  = strlen($indexContent);
	$lenghtSearch = strlen($search);
	$firstPart    = substr($indexContent, 0, $lastPosition + $lenghtSearch);
	$secondPart   = substr($indexContent, $lastPosition + $lenghtSearch);

	$inputContent = $firstPart
					. "\r\n    " 
					. '<p>' . $argv[1] . ': <a href="/' . $argv[1] . '">link</a></p>' 
					. $secondPart 
					. "\r\n";

	if (file_put_contents("index.php", $inputContent)) {
		die(" *** ЗМІНИ В INDEX ВНЕСЕНО! *** \r\n");
	}

} else {
	die(" *** ПЕРЕВІР ЧИ ПАТТЕРН ВЖЕ ІСНУЄ! *** \r\n");
}



?>