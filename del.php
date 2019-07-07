<?php
/*
* hide PHP warnings connected to error 
* "Permission denied" in Windows that occur during 
* deleting folders and files
*
*/
error_reporting(E_ERROR | E_PARSE);


//determine settings
$pattern 	= $argv[1];
$folder 	= __DIR__ . DIRECTORY_SEPARATOR . $pattern;
$indexFile 	= __DIR__ . DIRECTORY_SEPARATOR . "index.php";

//check if pattern has been determinated
if (! isset($pattern)) {
	die(" *** ВКАЖІТЬ БУДЬ-ЛАСКА ПАТТЕРН *** \r\n");
}

//check if direacotry exists and 
//if not skip this step and go to index file
if (! is_dir($folder)) {
	echo " *** ПАПКА НЕ ЗНАЙДЕНА! ПРОБУЄМО ЗНАЙТИ В INDEX *** \r\n";

} else {
	$filesList = scandir($folder);

	if (count($filesList) === 0) {
		if (rmdir($folder)) {
			echo " *** ПАПКА ВИДАЛЕНА УСПІШНО !!! *** \r\n";	
		}

	} else {
		foreach ($filesList as $file) {
			unlink($folder . DIRECTORY_SEPARATOR . $file);
		}
		if (rmdir($folder)) {
			echo " *** ПАПКА ВИДАЛЕНА УСПІШНО !!! *** \r\n";	
		}
	}
}


//get data from index file
$dataIndex = file_get_contents($indexFile);

//check if pattern has been used in index file
if (strpos($dataIndex, $pattern) === FALSE) {
	die(" *** ПАТТЕРН В INDEX НЕ ЗНАЙДЕНО *** \r\n");
}

$dataIndex = explode("\r\n", $dataIndex);
foreach ($dataIndex as $key => $row) {
	if (strpos($row, $pattern) > 0) {
		unset($dataIndex[$key]);
		continue;
	}
	$dataIndex[$key] .= "\r\n";
}
if (file_put_contents($indexFile, $dataIndex)) {
	die(" *** ЗМІНИ В INDEX УСПІШНО ВНЕСЕНО !!! *** \r\n");
}