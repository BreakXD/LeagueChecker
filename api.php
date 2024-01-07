<?php
function requireAll($dir) {
    foreach (glob("$dir/*.php") as $file) {
        require $file;
    }
}

requireAll("api/utils");
requireAll("api");

// CFG
if(!isset($_GET['user']) || !isset($_GET['pass'])){
	$user = "USER";
	$pass = "PASSWORD";
}else{
	$user = $_GET['user'];
	$pass = $_GET['pass'];
}

if(strlen($user) < 2 || strlen($pass) < 2) return;

$GLOBALS['config'] = \utils\Utils::getConfigJson();
if(!is_array($GLOBALS['config'])){
	echo $GLOBALS['config'];
	return;
}

if($GLOBALS['config']['variable']['hydra_key'] == ""){
	echo "REQUIRED: hydra_key is missing in config.json";
	return;
} 

$GLOBALS['startTime'] = time();
$GLOBALS['debugMode'] = $GLOBALS['config']['variable']['debug_mode'];
$GLOBALS['returnMode'] = $GLOBALS['config']['variable']['return_mode'];
$GLOBALS['exploit'] = $GLOBALS['config']['variable']['exploit'];
try{
	$newCheck = new \newAccount\StartCheck($user, $pass);
	if($GLOBALS['returnMode']){
		$newCheck->returnAccount("text");
	}
	//$newCheck = new \newAccount\StartCheck($_GET['user'], $_GET['password']);
	if($GLOBALS['debugMode']){
		echo PHP_EOL.'Total time spent: '.time() - $GLOBALS['startTime'].' seconds';
	}
} catch(Exception $e){
	echo $e->getMessage();
}

?>
