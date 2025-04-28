<?php

/*
    this is the base init for all scripts
*/

define("DEBUG_MODE", 1);
if(DEBUG_MODE) error_reporting(E_ALL);

require_once __DIR__."/incl.php";

define("CONN", DBManager::connect(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS));
define("CRON", new Cron());

$ip = PROTECTOR::getIP();
if(PROTECTOR::checkIfBanned(ip:$ip))
die(JSONConnector::baseJson(ERROR_IP_BANNED, MESSAGE_ERROR_IP_BANNED));

CRON->perform($ip);

?>