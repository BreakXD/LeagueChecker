<?php
$config = array("variable" => array(), "endpoint" => array());
$path = "api/data/config.json";

$usw_region = array(
    'BR1' => 'usw2-green',
    'LA1' => 'usw2-green',
    'LA2' => 'usw2-green',
    'NA1' => 'usw2-green',
    'OC1' => 'usw2-green',
    'RU' => 'euc1-green',
    'TR1' => 'euc1-green',
    'EUN1' => 'euc1-green',
    'EUW1' => 'euc1-green',
    'JP1' => 'apne1-green',
    'KR' => 'apne1-green'
);

$ledge_region = array(
    'BR1' => 'br-red',
    'EUN1' => 'eune-red',
    'EUW1' => 'euw-red',
    'JP1' => 'jp-red',
    'LA1' => 'las-red',
    'LA2' => 'lan-red',
    'NA1' => 'na-red',
    'OC1' => 'oce-red',
    'RU' => 'ru-blue',
    'TR1' => 'tr-blue',
    'KR' => 'kr-blue'
);

$store_region = array(
    "BR1" => "br",
    "EUN1" => "eun",
    "EUW1" => "euw",
    "JP1" => "jp",
    "LA1" => "la1",
    "LA2" => "la2",
    "NA1" => "na",
    "OC1" => "oc",
    "RU" => "ru",
    "TR1" => "tr",
    "KR" => "kr"
);

$loot_region = array(
    "BR1" => "lolriot.aws-usw2-prod.br1",
    "EUN1" => "lolriot.euc1.eun1",
    "EUW1" => "lolriot.ams1.euw1",
    "JP1" => "lolriot.aws-apne1-prod.jp1",
    "LA1" => "lolriot.aws-usw2-prod.la1",
    "LA2" => "lolriot.aws-usw2-prod.la2",
    "NA1" => "lolriot.aws-usw2-prod.na1",
    "OC1" => "lolriot.aws-apse1-prod.oc1",
    "RU1" => "lolriot.euc1.ru",
    "TR1" => "lolriot.euc1.tr1"

);

$hydraKey = "";
$debugMode = false;
$returnMode = true;
$exploit = false;

$config['endpoint']['usw_region'] = $usw_region;
$config['endpoint']['ledge_region'] = $ledge_region;
$config['endpoint']['store_region'] = $store_region;
$config['endpoint']['loot_region'] = $loot_region;

$config['variable']['hydra_key'] = $hydraKey;
$config['variable']['debug_mode'] = $debugMode;
$config['variable']['return_mode'] = $returnMode;
$config['variable']['exploit'] = $exploit;

$configJson = json_encode($config, JSON_PRETTY_PRINT);

$fp = fopen($path, "w");
$fResult = fwrite($fp, $configJson);
fclose($fp);

if(!$fResult){
	echo 'Fail write in '.$path.PHP_EOL;
}else{
	echo 'Sucessfully write in '.$path.PHP_EOL;
}





?>