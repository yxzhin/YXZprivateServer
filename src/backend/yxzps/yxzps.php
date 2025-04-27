<?php

/*
    this is the base init for all scripts
*/

define("DEBUG_MODE", 1);
if(DEBUG_MODE) error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__."/incl.php";

define("CONN", DBManager::connect(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS));
define("CRON", new Cron());
define("ENCRYPTOR", new Encryptor());
define("FILTER", new Filter());
define("GDCONNECTOR", new GDConnector());
define("JSONCONNECTOR", new JSONConnector());
define("PROTECTOR", new Protector());

$ip = PROTECTOR->getIP();
if(PROTECTOR->checkIfBanned(ip:$ip))
die(MESSAGE_ERROR_IP_BANNED);

CRON->perform($ip);

?>