<?php

require_once __DIR__."/../../yxzps/yxzps.php";

if(function_exists("set_time_limit"))
set_time_limit(0);

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9"
|| !Protector::checkGameAndBinaryVersion())
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$accountID = $_POST["accountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";

$account = new Account();

$result = $account->login(accountID:$accountID, gjp2:$gjp2, return_success:true);
$account->load($accountID);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$result = $account->syncAccount();

echo JSON ?
JSONConnector::syncAccount($result) :
$result;

?>