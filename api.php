<?php
function requireAll($dir) {
    foreach (glob("$dir/*.php") as $file) {
        require $file;
    }
}
requireAll("api/utils");
requireAll("api");

if(!isset($_GET['user']) || !isset($_GET['pass'])){
	$user = "USER";
	$pass = "PASSWORD";
}else{
	$user = $_GET['user'];
	$pass = $_GET['pass'];
}

if(strlen($user) < 2 || strlen($pass) < 2) return;

$GLOBALS['config'] = \utils\Utils::getConfigJson();
$GLOBALS['startTime'] = time();
$GLOBALS['debugMode'] = $GLOBALS['config']['variable']['debug_mode'];
$GLOBALS['returnMode'] = $GLOBALS['config']['variable']['return_mode'];
$GLOBALS['exploit'] = $GLOBALS['config']['variable']['exploit'];

if($GLOBALS['config']['variable']['hydra_key'] == ""){
	echo "REQUIRED: hydra_key is missing in config.json";
	return;
} 

try{
	$newCheck = new \newAccount\StartCheck($user, $pass);

	if($GLOBALS['returnMode']){
		$newCheck->returnAccount("text");
	}

	if($GLOBALS['debugMode']){
		echo PHP_EOL.'Total time spent: '.time() - $GLOBALS['startTime'].' seconds';
	}
} catch(Exception $e){
	echo $e->getMessage();
}

?>
