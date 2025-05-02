<?php

require_once __DIR__."/../../yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9"
|| !Protector::checkGameAndBinaryVersion())
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$accountID = $_POST["accountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";
$save_data = $_POST["save_data"] ?? "";

$account = new Account();

$result = $account->login(accountID:$accountID, gjp2:$gjp2, return_success:true);
$account->load($accountID);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$result = $account->backupAccount($save_data);

echo JSON ?
JSONConnector::backupAccount($result) :
GDConnector::backupAccount($result);

?>